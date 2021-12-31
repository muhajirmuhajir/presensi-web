<?php

namespace App\Exports;

use App\Models\User;
use App\Models\PresensiRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
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

class RekapPresensiExport implements ShouldAutoSize, FromView, WithStyles
{
    use Exportable;

    public $course_id;

    public function withCourseId($course_id)
    {
        $this->course_id = $course_id;
        return $this;
    }


    public function view(): View
    {
        $users =  User::leftJoin('presensi_records as r', 'r.student_id', 'users.id')
            ->leftJoin('presensis as p', 'p.id', 'r.presensi_id')
            ->leftJoin('courses as c', 'c.id', 'p.course_id')
            ->where('c.id', $this->course_id)
            ->select(
                'users.*',
            )->distinct()
            ->get();

        $records = PresensiRecord::join('presensis as p', 'p.id', 'presensi_records.presensi_id')
            ->join('courses as c', 'c.id', 'p.course_id')
            ->whereIn('presensi_records.student_id',  $users->pluck('id'))
            ->where('c.id', $this->course_id)
            ->select('presensi_records.*')
            ->distinct()
            ->get()
            ->groupBy('student_id');

        foreach ($users as $user) {
            $user->record_count = isset($records[$user->id]) ? $records[$user->id]->count() : 0;
            $user->status_pending_count = isset($records[$user->id]) ? $records[$user->id]->where('status', 1)->count() : 0;
            $user->status_present_count = isset($records[$user->id]) ? $records[$user->id]->where('status', 2)->count() : 0;
            $user->status_permit_count = isset($records[$user->id]) ? $records[$user->id]->where('status', 3)->count() : 0;
            $user->status_sick_count = isset($records[$user->id]) ? $records[$user->id]->where('status', 4)->count() : 0;
            $user->status_absent_count = isset($records[$user->id]) ? $records[$user->id]->where('status', 5)->count() : 0;
        }

        return view('templates.presensi_rekap', [
            'data' =>  $users
        ]);
    }

    public function styles(Worksheet $sheet)
    {

        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => Color::COLOR_GREEN],],]
        ];
    }
}
