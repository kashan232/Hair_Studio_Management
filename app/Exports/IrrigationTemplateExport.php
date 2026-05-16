<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class IrrigationTemplateExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(
        protected string $type = 'sub_divisions'
    ) {
        $this->type = in_array($type, ['circles', 'divisions', 'sub_divisions'], true) ? $type : 'sub_divisions';
    }

    public function title(): string
    {
        return match ($this->type) {
            'circles' => 'circles',
            'divisions' => 'divisions',
            default => 'sub_divisions',
        };
    }

    public function headings(): array
    {
        return match ($this->type) {
            'circles' => ['circle'],
            'divisions' => ['circle', 'division'],
            default => ['circle', 'division', 'sub_division'],
        };
    }

    public function collection(): Collection
    {
        return collect(match ($this->type) {
            'circles' => [['Sample Circle']],
            'divisions' => [['Sample Circle', 'Sample Division']],
            default => [['Sample Circle', 'Sample Division', 'Sample Sub Division']],
        });
    }
}
