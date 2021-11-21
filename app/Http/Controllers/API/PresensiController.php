<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\PresensiRecord;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $user_id = auth()->id();

        $presensi_records = PresensiRecord::join('presensis as p', 'p.id', 'presensi_records.presensi_id')
            ->join('courses as c', 'c.id', 'p.course_id')
            ->join('users as u', 'u.id', 'c.teacher_id')
            ->join('kelas as k', 'k.id', 'c.kelas_id')
            ->where('presensi_records.student_id', $user_id)
            ->select(
                'presensi_records.id as id',
                DB::raw("CONCAT(c.name, ' - ', k.name) as name"),
                'p.topic as topic',
                'presensi_records.status as status',
                'u.name as teacher_name'
            )->get();

        return ApiResponse::success($presensi_records);
    }
}
