<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ChannelTemplateExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(
        protected string $type = 'watercourses'
    ) {
        $this->type = in_array($type, [
            'barrages',
            'main_canals',
            'sub_canals',
            'branch_canals',
            'distributaries',
            'minors',
            'watercourses',
        ], true) ? $type : 'watercourses';
    }

    public function title(): string
    {
        return $this->type;
    }

    public function headings(): array
    {
        return match ($this->type) {
            'barrages' => ['barrage'],
            'main_canals' => ['barrage', 'main_canal'],
            'sub_canals' => ['barrage', 'main_canal', 'sub_canal'],
            'branch_canals' => ['barrage', 'main_canal', 'sub_canal', 'branch_canal'],
            'distributaries' => ['barrage', 'main_canal', 'sub_canal', 'branch_canal', 'distributary'],
            'minors' => ['barrage', 'main_canal', 'sub_canal', 'branch_canal', 'distributary', 'minor'],
            default => ['barrage', 'main_canal', 'sub_canal', 'branch_canal', 'distributary', 'minor', 'watercourse'],
        };
    }

    public function collection(): Collection
    {
        return collect(match ($this->type) {
            'barrages' => [['Guddu Barrage']],
            'main_canals' => [['Guddu Barrage', 'Main Nara']],
            'sub_canals' => [['Guddu Barrage', 'Main Nara', 'Sub Nara']],
            'branch_canals' => [['Guddu Barrage', 'Main Nara', 'Sub Nara', 'Branch 1']],
            'distributaries' => [['Guddu Barrage', 'Main Nara', 'Sub Nara', 'Branch 1', 'Disty A']],
            'minors' => [['Guddu Barrage', 'Main Nara', 'Sub Nara', 'Branch 1', 'Disty A', 'Minor 1']],
            default => [['Guddu Barrage', 'Main Nara', 'Sub Nara', 'Branch 1', 'Disty A', 'Minor 1', 'WC-001']],
        });
    }
}
