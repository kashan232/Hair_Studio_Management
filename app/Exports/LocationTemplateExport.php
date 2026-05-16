<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class LocationTemplateExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(
        protected string $type = 'dehs'
    ) {
        $this->type = in_array($type, ['districts', 'talukas', 'tehsils', 'dehs'], true) ? $type : 'dehs';
    }

    public function title(): string
    {
        return match ($this->type) {
            'districts' => 'districts',
            'talukas' => 'talukas',
            'tehsils' => 'tehsils',
            default => 'dehs',
        };
    }

    public function headings(): array
    {
        return match ($this->type) {
            'districts' => ['district'],
            'talukas' => ['district', 'taluka'],
            'tehsils' => ['district', 'taluka', 'tehsil'],
            default => ['district', 'taluka', 'tehsil', 'deh'],
        };
    }

    public function collection(): Collection
    {
        return collect(match ($this->type) {
            'districts' => [['Sukkur']],
            'talukas' => [['Sukkur', 'Rohri']],
            'tehsils' => [['Sukkur', 'Rohri', 'Pano Aqil']],
            default => [['Sukkur', 'Rohri', 'Pano Aqil', 'Sample DEH']],
        });
    }
}
