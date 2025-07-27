<?php

namespace App\Http\Controllers\laboran;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function admin(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $schedules = PengajuanBooking::with(['jadwalBookings', 'user', 'laboratorium.lokasi'])->whereHas('jadwalBookings', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ])->where('status', '=', 'diterima');
        })->get();
        return view('laboran.laporan.index', compact('schedules'));
    }

    public function cetakAdmin(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $schedules = PengajuanBooking::with(['jadwalBookings', 'user', 'laboratorium'])->whereHas('jadwalBookings', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ])->where('status', '=', 'diterima');
        })->get();
        return view('laboran.laporan.cetak', compact('schedules', 'startDate', 'endDate'));
    }
}
