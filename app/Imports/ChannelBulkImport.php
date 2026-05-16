<?php

namespace App\Imports;

use App\Models\Barrage;
use App\Models\BranchCanal;
use App\Models\Distributary;
use App\Models\MainCanal;
use App\Models\Minor;
use App\Models\SubCanal;
use App\Models\Watercourse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ChannelBulkImport implements ToCollection, WithHeadingRow
{
    private const BATCH_ABORT = 'channel_import_batch_abort';

    private const MODES = [
        'barrages',
        'main_canals',
        'sub_canals',
        'branch_canals',
        'distributaries',
        'minors',
        'watercourses',
    ];

    public int $rowsImported = 0;

    public int $rowsDuplicate = 0;

    public int $rowsSkipped = 0;

    /** @var list<string> */
    public array $errors = [];

    public function __construct(
        protected string $mode = 'watercourses'
    ) {
        $this->mode = in_array($mode, self::MODES, true) ? $mode : 'watercourses';
    }

    public function collection(Collection $collection): void
    {
        $this->runBatchTransactional($collection);
    }

    /** @param  Collection<int, Collection<int|string, mixed>>  $collection */
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
                        'barrages' => $this->processBarrageRow($row, $excelRow),
                        'main_canals' => $this->processMainCanalRow($row, $excelRow),
                        'sub_canals' => $this->processSubCanalRow($row, $excelRow),
                        'branch_canals' => $this->processBranchCanalRow($row, $excelRow),
                        'distributaries' => $this->processDistributaryRow($row, $excelRow),
                        'minors' => $this->processMinorRow($row, $excelRow),
                        default => $this->processWatercourseRow($row, $excelRow),
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
            'barrages' => 'Barrage import rolled back — no rows were saved.',
            'main_canals' => 'Main canal import rolled back — no rows were saved.',
            'sub_canals' => 'Sub canal import rolled back — no rows were saved.',
            'branch_canals' => 'Branch canal import rolled back — no rows were saved.',
            'distributaries' => 'Distributary import rolled back — no rows were saved.',
            'minors' => 'Minor import rolled back — no rows were saved.',
            default => 'Watercourse import rolled back — no rows were saved.',
        };
    }

    protected function abortBatch(string $message): never
    {
        $this->errors[] = $message;
        throw new \RuntimeException(self::BATCH_ABORT);
    }

    /** @param  Collection<int|string, mixed>|array<string, mixed>  $row */
    protected function processBarrageRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $barrage = $this->cell($data, ['barrage', 'barrage_name', 'name']);

        if ($barrage === '') {
            $this->rowsSkipped++;

            return;
        }

        if ($this->tooLong($barrage)) {
            $this->abortBatch("{$excelRow}: Barrage name must be 255 characters or less.");
        }

        $model = Barrage::firstOrCreate(['name' => $barrage]);
        $model->wasRecentlyCreated ? $this->rowsImported++ : $this->rowsDuplicate++;
    }

    /** @param  Collection<int|string, mixed>|array<string, mixed>  $row */
    protected function processMainCanalRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $barrage = $this->cell($data, ['barrage', 'barrage_name']);
        $mainCanal = $this->cell($data, ['main_canal', 'main_canal_name']);

        if ($barrage === '' && $mainCanal === '') {
            $this->rowsSkipped++;

            return;
        }

        if ($barrage === '' || $mainCanal === '') {
            $this->abortBatch("{$excelRow}: Both barrage and main canal are required for main canal import.");
        }

        $barrageRecord = $this->requireBarrage($barrage, $excelRow);
        $this->guardLength($excelRow, ['main canal' => $mainCanal]);

        $model = MainCanal::firstOrCreate(
            ['barrage_id' => $barrageRecord->id, 'name' => $mainCanal]
        );
        $model->wasRecentlyCreated ? $this->rowsImported++ : $this->rowsDuplicate++;
    }

    /** @param  Collection<int|string, mixed>|array<string, mixed>  $row */
    protected function processSubCanalRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $barrage = $this->cell($data, ['barrage', 'barrage_name']);
        $mainCanal = $this->cell($data, ['main_canal', 'main_canal_name']);
        $subCanal = $this->cell($data, ['sub_canal', 'sub_canal_name']);

        if ($barrage === '' && $mainCanal === '' && $subCanal === '') {
            $this->rowsSkipped++;

            return;
        }

        if ($barrage === '' || $mainCanal === '' || $subCanal === '') {
            $this->abortBatch("{$excelRow}: Barrage, main canal, and sub canal are required for sub canal import.");
        }

        $mainRecord = $this->requireMainCanal($barrage, $mainCanal, $excelRow);
        $this->guardLength($excelRow, ['sub canal' => $subCanal]);

        $model = SubCanal::firstOrCreate([
            'main_canal_id' => $mainRecord->id,
            'name' => $subCanal,
        ]);
        $model->wasRecentlyCreated ? $this->rowsImported++ : $this->rowsDuplicate++;
    }

    /** @param  Collection<int|string, mixed>|array<string, mixed>  $row */
    protected function processBranchCanalRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $barrage = $this->cell($data, ['barrage', 'barrage_name']);
        $mainCanal = $this->cell($data, ['main_canal', 'main_canal_name']);
        $subCanal = $this->cell($data, ['sub_canal', 'sub_canal_name']);
        $branchCanal = $this->cell($data, ['branch_canal', 'branch_canal_name']);

        if ($barrage === '' && $mainCanal === '' && $subCanal === '' && $branchCanal === '') {
            $this->rowsSkipped++;

            return;
        }

        if ($barrage === '' || $mainCanal === '' || $subCanal === '' || $branchCanal === '') {
            $this->abortBatch("{$excelRow}: Barrage, main canal, sub canal, and branch canal are required.");
        }

        $subRecord = $this->requireSubCanal($barrage, $mainCanal, $subCanal, $excelRow);
        $this->guardLength($excelRow, ['branch canal' => $branchCanal]);

        $model = BranchCanal::firstOrCreate([
            'sub_canal_id' => $subRecord->id,
            'name' => $branchCanal,
        ]);
        $model->wasRecentlyCreated ? $this->rowsImported++ : $this->rowsDuplicate++;
    }

    /** @param  Collection<int|string, mixed>|array<string, mixed>  $row */
    protected function processDistributaryRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $barrage = $this->cell($data, ['barrage', 'barrage_name']);
        $mainCanal = $this->cell($data, ['main_canal', 'main_canal_name']);
        $subCanal = $this->cell($data, ['sub_canal', 'sub_canal_name']);
        $branchCanal = $this->cell($data, ['branch_canal', 'branch_canal_name']);
        $distributary = $this->cell($data, ['distributary', 'distributary_name']);

        if ($barrage === '' && $mainCanal === '' && $subCanal === '' && $branchCanal === '' && $distributary === '') {
            $this->rowsSkipped++;

            return;
        }

        if ($barrage === '' || $mainCanal === '' || $subCanal === '' || $branchCanal === '' || $distributary === '') {
            $this->abortBatch("{$excelRow}: All parent columns and distributary are required.");
        }

        $branchRecord = $this->requireBranchCanal($barrage, $mainCanal, $subCanal, $branchCanal, $excelRow);
        $this->guardLength($excelRow, ['distributary' => $distributary]);

        $model = Distributary::firstOrCreate([
            'branch_canal_id' => $branchRecord->id,
            'name' => $distributary,
        ]);
        $model->wasRecentlyCreated ? $this->rowsImported++ : $this->rowsDuplicate++;
    }

    /** @param  Collection<int|string, mixed>|array<string, mixed>  $row */
    protected function processMinorRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $barrage = $this->cell($data, ['barrage', 'barrage_name']);
        $mainCanal = $this->cell($data, ['main_canal', 'main_canal_name']);
        $subCanal = $this->cell($data, ['sub_canal', 'sub_canal_name']);
        $branchCanal = $this->cell($data, ['branch_canal', 'branch_canal_name']);
        $distributary = $this->cell($data, ['distributary', 'distributary_name']);
        $minor = $this->cell($data, ['minor', 'minor_name']);

        if ($barrage === '' && $mainCanal === '' && $subCanal === '' && $branchCanal === '' && $distributary === '' && $minor === '') {
            $this->rowsSkipped++;

            return;
        }

        if ($barrage === '' || $mainCanal === '' || $subCanal === '' || $branchCanal === '' || $distributary === '' || $minor === '') {
            $this->abortBatch("{$excelRow}: All parent columns and minor are required.");
        }

        $distRecord = $this->requireDistributary($barrage, $mainCanal, $subCanal, $branchCanal, $distributary, $excelRow);
        $this->guardLength($excelRow, ['minor' => $minor]);

        $model = Minor::firstOrCreate([
            'distributary_id' => $distRecord->id,
            'name' => $minor,
        ]);
        $model->wasRecentlyCreated ? $this->rowsImported++ : $this->rowsDuplicate++;
    }

    /** @param  Collection<int|string, mixed>|array<string, mixed>  $row */
    protected function processWatercourseRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $barrage = $this->cell($data, ['barrage', 'barrage_name']);
        $mainCanal = $this->cell($data, ['main_canal', 'main_canal_name']);
        $subCanal = $this->cell($data, ['sub_canal', 'sub_canal_name']);
        $branchCanal = $this->cell($data, ['branch_canal', 'branch_canal_name']);
        $distributary = $this->cell($data, ['distributary', 'distributary_name']);
        $minor = $this->cell($data, ['minor', 'minor_name']);
        $watercourse = $this->cell($data, ['watercourse', 'watercourse_name', 'wc_no', 'wc']);

        if ($barrage === '' && $mainCanal === '' && $subCanal === '' && $branchCanal === '' && $distributary === '' && $minor === '' && $watercourse === '') {
            $this->rowsSkipped++;

            return;
        }

        if ($barrage === '' || $mainCanal === '' || $subCanal === '' || $branchCanal === '' || $distributary === '' || $minor === '' || $watercourse === '') {
            $this->abortBatch("{$excelRow}: Full hierarchy and watercourse (WC) are required.");
        }

        $minorRecord = $this->requireMinor($barrage, $mainCanal, $subCanal, $branchCanal, $distributary, $minor, $excelRow);
        $this->guardLength($excelRow, ['watercourse' => $watercourse]);

        $model = Watercourse::firstOrCreate([
            'minor_id' => $minorRecord->id,
            'name' => $watercourse,
        ]);
        $model->wasRecentlyCreated ? $this->rowsImported++ : $this->rowsDuplicate++;
    }

    protected function requireBarrage(string $barrage, int $excelRow): Barrage
    {
        if ($this->tooLong($barrage)) {
            $this->abortBatch("{$excelRow}: Barrage name must be 255 characters or less.");
        }

        $record = Barrage::query()->where('name', $barrage)->first();
        if ($record === null) {
            $safe = Str::limit($barrage, 80);
            $this->abortBatch("{$excelRow}: Barrage not found ({$safe}). Insert it first OR fix spelling.");
        }

        return $record;
    }

    protected function requireMainCanal(string $barrage, string $mainCanal, int $excelRow): MainCanal
    {
        $barrageRecord = $this->requireBarrage($barrage, $excelRow);
        if ($this->tooLong($mainCanal)) {
            $this->abortBatch("{$excelRow}: Main canal name must be 255 characters or less.");
        }

        $record = MainCanal::query()
            ->where('barrage_id', $barrageRecord->id)
            ->where('name', $mainCanal)
            ->first();

        if ($record === null) {
            $safe = Str::limit($mainCanal, 80);
            $this->abortBatch("{$excelRow}: Main canal \"{$safe}\" not found under barrage. Import main canals first OR fix spelling.");
        }

        return $record;
    }

    protected function requireSubCanal(string $barrage, string $mainCanal, string $subCanal, int $excelRow): SubCanal
    {
        $mainRecord = $this->requireMainCanal($barrage, $mainCanal, $excelRow);
        if ($this->tooLong($subCanal)) {
            $this->abortBatch("{$excelRow}: Sub canal name must be 255 characters or less.");
        }

        $record = SubCanal::query()
            ->where('main_canal_id', $mainRecord->id)
            ->where('name', $subCanal)
            ->first();

        if ($record === null) {
            $safe = Str::limit($subCanal, 80);
            $this->abortBatch("{$excelRow}: Sub canal \"{$safe}\" not found. Import sub canals first OR fix spelling.");
        }

        return $record;
    }

    protected function requireBranchCanal(string $barrage, string $mainCanal, string $subCanal, string $branchCanal, int $excelRow): BranchCanal
    {
        $subRecord = $this->requireSubCanal($barrage, $mainCanal, $subCanal, $excelRow);
        if ($this->tooLong($branchCanal)) {
            $this->abortBatch("{$excelRow}: Branch canal name must be 255 characters or less.");
        }

        $record = BranchCanal::query()
            ->where('sub_canal_id', $subRecord->id)
            ->where('name', $branchCanal)
            ->first();

        if ($record === null) {
            $safe = Str::limit($branchCanal, 80);
            $this->abortBatch("{$excelRow}: Branch canal \"{$safe}\" not found. Import branch canals first OR fix spelling.");
        }

        return $record;
    }

    protected function requireDistributary(string $barrage, string $mainCanal, string $subCanal, string $branchCanal, string $distributary, int $excelRow): Distributary
    {
        $branchRecord = $this->requireBranchCanal($barrage, $mainCanal, $subCanal, $branchCanal, $excelRow);
        if ($this->tooLong($distributary)) {
            $this->abortBatch("{$excelRow}: Distributary name must be 255 characters or less.");
        }

        $record = Distributary::query()
            ->where('branch_canal_id', $branchRecord->id)
            ->where('name', $distributary)
            ->first();

        if ($record === null) {
            $safe = Str::limit($distributary, 80);
            $this->abortBatch("{$excelRow}: Distributary \"{$safe}\" not found. Import distributaries first OR fix spelling.");
        }

        return $record;
    }

    protected function requireMinor(string $barrage, string $mainCanal, string $subCanal, string $branchCanal, string $distributary, string $minor, int $excelRow): Minor
    {
        $distRecord = $this->requireDistributary($barrage, $mainCanal, $subCanal, $branchCanal, $distributary, $excelRow);
        if ($this->tooLong($minor)) {
            $this->abortBatch("{$excelRow}: Minor name must be 255 characters or less.");
        }

        $record = Minor::query()
            ->where('distributary_id', $distRecord->id)
            ->where('name', $minor)
            ->first();

        if ($record === null) {
            $safe = Str::limit($minor, 80);
            $this->abortBatch("{$excelRow}: Minor \"{$safe}\" not found. Import minors first OR fix spelling.");
        }

        return $record;
    }

    /** @param  array<string, string>  $fields */
    protected function guardLength(int $excelRow, array $fields): void
    {
        foreach ($fields as $label => $val) {
            if ($this->tooLong($val)) {
                $this->abortBatch("{$excelRow}: {$label} name must be 255 characters or less.");
            }
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
