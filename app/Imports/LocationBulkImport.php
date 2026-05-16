<?php

namespace App\Imports;

use App\Models\Deh;
use App\Models\District;
use App\Models\Taluka;
use App\Models\Tehsil;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LocationBulkImport implements ToCollection, WithHeadingRow
{
    private const BATCH_ABORT = 'location_import_batch_abort';

    public int $rowsImported = 0;

    /** Rows where the leaf record already existed (no duplicate inserted). */
    public int $rowsDuplicate = 0;

    public int $rowsSkipped = 0;

    /** @var list<string> */
    public array $errors = [];

    public function __construct(
        protected string $mode = 'dehs'
    ) {
        $this->mode = in_array($mode, ['districts', 'talukas', 'tehsils', 'dehs'], true) ? $mode : 'dehs';
    }

    public function collection(Collection $collection): void
    {
        $this->runBatchTransactional($collection);
    }

    /**
     * Every import type runs in a single DB transaction.
     * Any validation / missing-parent error rolls back the entire file.
     *
     * @param  Collection<int, Collection<int|string, mixed>>  $collection
     */
    protected function runBatchTransactional(Collection $collection): void
    {
        $this->rowsImported = 0;
        $this->rowsDuplicate = 0;
        $this->rowsSkipped = 0;

        try {
            DB::transaction(function () use ($collection) {
                foreach ($collection as $index => $row) {
                    if (count($this->errors) >= 150) {
                        $this->abortBatch('Import stopped after 150 error lines. Nothing was saved — fix the sheet and try again.');
                    }
                    $excelRow = $index + 2;

                    match ($this->mode) {
                        'districts' => $this->processDistrictRow($row, $excelRow),
                        'talukas' => $this->processTalukaRow($row, $excelRow),
                        'tehsils' => $this->processTehsilRow($row, $excelRow),
                        default => $this->processDehRow($row, $excelRow),
                    };
                }
            });
        } catch (\RuntimeException $e) {
            if ($e->getMessage() !== self::BATCH_ABORT) {
                throw $e;
            }
            $this->rowsImported = 0;
            $this->rowsDuplicate = 0;
            $this->rowsSkipped = 0;
            array_unshift($this->errors, $this->rollbackSummaryMessage());
        }
    }

    protected function rollbackSummaryMessage(): string
    {
        return match ($this->mode) {
            'districts' => 'District import rolled back — no rows were saved.',
            'talukas' => 'Taluka import rolled back — no rows were saved.',
            'tehsils' => 'Tehsil import rolled back — no rows were saved.',
            default => 'DEH import rolled back — no rows were saved.',
        };
    }

    protected function abortBatch(string $message): never
    {
        $this->errors[] = $message;
        throw new \RuntimeException(self::BATCH_ABORT);
    }

    /** @param  Collection<int|string, mixed>|array<string, mixed>  $row */
    protected function processDistrictRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $district = $this->cell($data, ['district', 'district_name', 'name']);

        if ($district === '') {
            $this->rowsSkipped++;

            return;
        }

        if ($this->tooLong($district)) {
            $this->abortBatch("{$excelRow}: District name must be 255 characters or less.");
        }

        $districtModel = District::firstOrCreate(['name' => $district]);
        if ($districtModel->wasRecentlyCreated) {
            $this->rowsImported++;
        } else {
            $this->rowsDuplicate++;
        }
    }

    /** @param  Collection<int|string, mixed>|array<string, mixed>  $row */
    protected function processTalukaRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $district = $this->cell($data, ['district', 'district_name']);
        $taluka = $this->cell($data, ['taluka', 'taluka_name']);

        if ($district === '' && $taluka === '') {
            $this->rowsSkipped++;

            return;
        }

        if ($district === '' || $taluka === '') {
            $this->abortBatch("{$excelRow}: Both district and taluka are required for taluka import.");
        }

        foreach (['district' => $district, 'taluka' => $taluka] as $label => $val) {
            if ($this->tooLong($val)) {
                $this->abortBatch("{$excelRow}: {$label} name must be 255 characters or less.");
            }
        }

        $districtRecord = District::query()->where('name', $district)->first();

        if ($districtRecord === null) {
            $safeDistrict = Str::limit($district, 80);
            $this->abortBatch(
                "{$excelRow}: District not found ({$safeDistrict}). Please insert the district first OR fix spelling."
            );
        }

        $talukaModel = Taluka::firstOrCreate(
            ['district_id' => $districtRecord->id, 'name' => $taluka]
        );

        if ($talukaModel->wasRecentlyCreated) {
            $this->rowsImported++;
        } else {
            $this->rowsDuplicate++;
        }
    }

    /** @param  Collection<int|string, mixed>|array<string, mixed>  $row */
    protected function processTehsilRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $district = $this->cell($data, ['district', 'district_name']);
        $taluka = $this->cell($data, ['taluka', 'taluka_name']);
        $tehsil = $this->cell($data, ['tehsil', 'tehsil_name']);

        if ($district === '' && $taluka === '' && $tehsil === '') {
            $this->rowsSkipped++;

            return;
        }

        if ($district === '' || $taluka === '' || $tehsil === '') {
            $this->abortBatch("{$excelRow}: District, taluka, and tehsil are required for tehsil import.");
        }

        foreach (compact('district', 'taluka', 'tehsil') as $label => $val) {
            if ($this->tooLong($val)) {
                $this->abortBatch("{$excelRow}: {$label} name must be 255 characters or less.");
            }
        }

        $districtRecord = District::query()->where('name', $district)->first();
        if ($districtRecord === null) {
            $safe = Str::limit($district, 80);
            $this->abortBatch(
                "{$excelRow}: District not found ({$safe}). Insert it first OR fix spelling."
            );
        }

        $talukaRecord = Taluka::query()
            ->where('district_id', $districtRecord->id)
            ->where('name', $taluka)
            ->first();

        if ($talukaRecord === null) {
            $talLim = Str::limit($taluka, 80);
            $distLim = Str::limit($district, 80);
            $this->abortBatch("{$excelRow}: Taluka \"{$talLim}\" not found under district \"{$distLim}\". Import talukas first OR fix spelling.");
        }

        $tehsilModel = Tehsil::firstOrCreate([
            'taluka_id' => $talukaRecord->id,
            'name' => $tehsil,
        ]);

        if ($tehsilModel->wasRecentlyCreated) {
            $this->rowsImported++;
        } else {
            $this->rowsDuplicate++;
        }
    }

    /** @param  Collection<int|string, mixed>|array<string, mixed>  $row */
    protected function processDehRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $district = $this->cell($data, ['district', 'district_name']);
        $taluka = $this->cell($data, ['taluka', 'taluka_name']);
        $tehsil = $this->cell($data, ['tehsil', 'tehsil_name']);
        $deh = $this->cell($data, ['deh', 'deh_name']);

        if ($district === '' && $taluka === '' && $tehsil === '' && $deh === '') {
            $this->rowsSkipped++;

            return;
        }

        if ($district === '' || $taluka === '' || $tehsil === '' || $deh === '') {
            $this->abortBatch("{$excelRow}: District, taluka, tehsil, and deh are required for DEH import.");
        }

        foreach (compact('district', 'taluka', 'tehsil', 'deh') as $label => $val) {
            if ($this->tooLong($val)) {
                $this->abortBatch("{$excelRow}: {$label} name must be 255 characters or less.");
            }
        }

        $districtRecord = District::query()->where('name', $district)->first();
        if ($districtRecord === null) {
            $safe = Str::limit($district, 80);
            $this->abortBatch(
                "{$excelRow}: District not found ({$safe}). Insert it first OR fix spelling."
            );
        }

        $talukaRecord = Taluka::query()
            ->where('district_id', $districtRecord->id)
            ->where('name', $taluka)
            ->first();

        if ($talukaRecord === null) {
            $safe = Str::limit($taluka, 80);
            $this->abortBatch(
                "{$excelRow}: Taluka not found under district ({$safe}). Import talukas first OR fix spelling."
            );
        }

        $tehsilRecord = Tehsil::query()
            ->where('taluka_id', $talukaRecord->id)
            ->where('name', $tehsil)
            ->first();

        if ($tehsilRecord === null) {
            $safe = Str::limit($tehsil, 80);
            $this->abortBatch(
                "{$excelRow}: Tehsil not found under taluka ({$safe}). Import tehsils first OR fix spelling."
            );
        }

        $dehModel = Deh::firstOrCreate([
            'tehsil_id' => $tehsilRecord->id,
            'name' => $deh,
        ]);

        if ($dehModel->wasRecentlyCreated) {
            $this->rowsImported++;
        } else {
            $this->rowsDuplicate++;
        }
    }

    /** @param  Collection<int|string, mixed>|array<string, mixed>  $row */
    protected function normalizeRow(Collection|array $row): array
    {
        $arr = $row instanceof Collection ? $row->toArray() : $row;
        $out = [];
        foreach ($arr as $k => $v) {
            $key = is_string($k)
                ? strtolower(str_replace('-', '_', Str::slug($k, '_')))
                : 'col_'.$k;
            $out[$key] = $v;
        }

        return $out;
    }

    /** @param  array<string, mixed>  $data */
    protected function cell(array $data, array $keys): string
    {
        foreach ($keys as $key) {
            $variants = [$key, Str::slug($key, '_'), strtolower(str_replace('-', '_', $key))];
            foreach ($variants as $vk) {
                if (! array_key_exists($vk, $data)) {
                    continue;
                }
                $v = $data[$vk];
                if ($v === null || $v === '') {
                    continue;
                }
                $s = trim((string) $v);
                if ($s === '') {
                    continue;
                }

                return Str::limit($s, 255, '');
            }
        }

        foreach ($keys as $want) {
            $wantNorm = strtolower(str_replace(' ', '_', $want));
            foreach ($data as $k => $v) {
                if (! is_string($k)) {
                    continue;
                }
                if (strtolower(str_replace([' ', '-'], '_', trim($k))) !== $wantNorm) {
                    continue;
                }
                if ($v === null || $v === '') {
                    continue;
                }
                $s = trim((string) $v);

                return $s !== '' ? Str::limit($s, 255, '') : '';
            }
        }

        return '';
    }

    protected function tooLong(string $s): bool
    {
        return mb_strlen($s) > 255;
    }
}
