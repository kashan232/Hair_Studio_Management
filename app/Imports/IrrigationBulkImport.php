<?php

namespace App\Imports;

use App\Models\Circle;
use App\Models\Division;
use App\Models\SubDivision;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IrrigationBulkImport implements ToCollection, WithHeadingRow
{
    private const BATCH_ABORT = 'irrigation_import_batch_abort';

    public int $rowsImported = 0;
    public int $rowsDuplicate = 0;
    public int $rowsSkipped = 0;
    public array $errors = [];

    public function __construct(
        protected string $mode = 'sub_divisions'
    ) {
        $this->mode = in_array($mode, ['circles', 'divisions', 'sub_divisions'], true) ? $mode : 'sub_divisions';
    }

    public function collection(Collection $collection): void
    {
        $this->runBatchTransactional($collection);
    }

    protected function runBatchTransactional(Collection $collection): void
    {
        $this->rowsImported = 0;
        $this->rowsDuplicate = 0;
        $this->rowsSkipped = 0;

        try {
            DB::transaction(function () use ($collection) {
                foreach ($collection as $index => $row) {
                    if (count($this->errors) >= 150) {
                        $this->abortBatch('Import stopped after 150 error lines. Nothing was saved.');
                    }
                    $excelRow = $index + 2;

                    match ($this->mode) {
                        'circles' => $this->processCircleRow($row, $excelRow),
                        'divisions' => $this->processDivisionRow($row, $excelRow),
                        default => $this->processSubDivisionRow($row, $excelRow),
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
            'circles' => 'Circle import rolled back.',
            'divisions' => 'Division import rolled back.',
            default => 'Sub Division import rolled back.',
        };
    }

    protected function abortBatch(string $message): never
    {
        $this->errors[] = $message;
        throw new \RuntimeException(self::BATCH_ABORT);
    }

    protected function processCircleRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $circle = $this->cell($data, ['circle', 'name']);

        if ($circle === '') {
            $this->rowsSkipped++;
            return;
        }

        $circleModel = Circle::firstOrCreate(['name' => $circle]);
        if ($circleModel->wasRecentlyCreated) {
            $this->rowsImported++;
        } else {
            $this->rowsDuplicate++;
        }
    }

    protected function processDivisionRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $circle = $this->cell($data, ['circle']);
        $division = $this->cell($data, ['division', 'name']);

        if ($circle === '' && $division === '') {
            $this->rowsSkipped++;
            return;
        }

        if ($circle === '' || $division === '') {
            $this->abortBatch("{$excelRow}: Circle and Division are required.");
        }

        $circleRecord = Circle::where('name', $circle)->first();
        if (!$circleRecord) {
            $this->abortBatch("{$excelRow}: Circle not found ({$circle}).");
        }

        $divisionModel = Division::firstOrCreate([
            'circle_id' => $circleRecord->id,
            'name' => $division
        ]);

        if ($divisionModel->wasRecentlyCreated) {
            $this->rowsImported++;
        } else {
            $this->rowsDuplicate++;
        }
    }

    protected function processSubDivisionRow(Collection|array $row, int $excelRow): void
    {
        $data = $this->normalizeRow($row);
        $circle = $this->cell($data, ['circle']);
        $division = $this->cell($data, ['division']);
        $subDivision = $this->cell($data, ['sub_division', 'name']);

        if ($circle === '' && $division === '' && $subDivision === '') {
            $this->rowsSkipped++;
            return;
        }

        if ($circle === '' || $division === '' || $subDivision === '') {
            $this->abortBatch("{$excelRow}: Circle, Division, and Sub Division are required.");
        }

        $circleRecord = Circle::where('name', $circle)->first();
        if (!$circleRecord) {
            $this->abortBatch("{$excelRow}: Circle not found ({$circle}).");
        }

        $divisionRecord = Division::where('circle_id', $circleRecord->id)
            ->where('name', $division)
            ->first();

        if (!$divisionRecord) {
            $this->abortBatch("{$excelRow}: Division not found ({$division}) under circle ({$circle}).");
        }

        $subDivisionModel = SubDivision::firstOrCreate([
            'division_id' => $divisionRecord->id,
            'name' => $subDivision
        ]);

        if ($subDivisionModel->wasRecentlyCreated) {
            $this->rowsImported++;
        } else {
            $this->rowsDuplicate++;
        }
    }

    protected function normalizeRow(Collection|array $row): array
    {
        $arr = $row instanceof Collection ? $row->toArray() : $row;
        $out = [];
        foreach ($arr as $k => $v) {
            $key = is_string($k) ? strtolower(str_replace('-', '_', Str::slug($k, '_'))) : 'col_'.$k;
            $out[$key] = $v;
        }
        return $out;
    }

    protected function cell(array $data, array $keys): string
    {
        foreach ($keys as $key) {
            $vk = strtolower(str_replace([' ', '-'], '_', $key));
            if (isset($data[$vk]) && $data[$vk] !== '') {
                return trim((string) $data[$vk]);
            }
        }
        return '';
    }
}
