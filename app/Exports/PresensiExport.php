<?php

namespace App\Exports;

use App\Models\PresensiRecord;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PresensiExport implements WithMapping, WithHeadings, ShouldAutoSize, FromView, WithStyles
{
    use Exportable;

    public $presensi_id;

    public function withId($presensi_id)
    {
        $this->presensi_id = $presensi_id;
        return $this;
    }


    public function map($presensi): array
    {
        return [
            $presensi->student->name,
            $presensi->status,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Status',
        ];
    }


    public function view(): View
    {
        return view('templates.presensi_record', [
            'data' =>  PresensiRecord::with('student')->where('presensi_id', $this->presensi_id)->get()
        ]);
    }

    public function styles(Worksheet $sheet)
    {

        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => Color::COLOR_GREEN],],]
        ];
    }
}
