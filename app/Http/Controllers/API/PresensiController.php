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

        $presensi_records = PresensiRecord::getListPresensiByUserId($user_id);

        return ApiResponse::success($presensi_records);
    }

    public function show(Request $request, $id)
    {
        $user_id = auth()->id();

        $presensi_record = PresensiRecord::getDetailPresensiByUserId($user_id, $id);

        return ApiResponse::success($presensi_record);
    }


    public function record(Request $request, $id)
    {
        $request->validate(
            [
                'status' => 'required|string',
                'answer' => 'nullable|string'
            ]
        );

        PresensiRecord::findOrFail($id)
        ->update(['status' => $request->status, 'answer' => $request->answer?? '']);

        $user_id = auth()->id();

        $presensi_record = PresensiRecord::getDetailPresensiByUserId($user_id, $id);

        return ApiResponse::success($presensi_record);

    }
}
