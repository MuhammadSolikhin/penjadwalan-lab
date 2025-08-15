<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\JadwalBooking;
use App\Models\PengajuanBooking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function admin(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $submissions = PengajuanBooking::with(['jadwalBookings', 'user', 'laboratorium.lokasi'])->whereHas('jadwalBookings', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ])->where('status', '=', 'diterima');
        })->get();
        return view('admin.laporan.index', compact('submissions'));
    }

    public function cetakAdmin(Request $request)
    {
        // Submission
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $submissions = PengajuanBooking::with(['jadwalBookings', 'user', 'laboratorium'])->whereHas('jadwalBookings', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ])->where('status', '=', 'diterima');
        })->get();

        // Total all schedules and schedules per building
        $schedules = JadwalBooking::with(['laboratoriumUnpam'])->get();
        $counts = [];
        for ($i = 0; $i < 5; $i++) {
            $location_id = $i + 2;
            $counts[$i] = $schedules->filter(function ($item) use ($location_id) {
                return $item->laboratoriumUnpam->lokasi_id == $location_id;
            })->count();
        }

        // Top frequent user
        $topFrequent = User::withCount(['jadwalBookings as jadwal_bookings_count' => function ($query) use ($startDate, $endDate) {
            $query->where('status', '=', 'diterima')->whereBetween('jadwal_bookings.created_at', [$startDate, $endDate]);
        }])
            ->orderByDesc('jadwal_bookings_count')
            ->limit(5)
            ->get();
        return view('admin.laporan.cetak', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'submissions' => $submissions,
            'schedules' => $schedules,
            'pusatCount' => $counts[0],
            'witanaCount' => $counts[1],
            'viktorCount' => $counts[2],
            'serangCount' => $counts[3],
            'topFrequent' => $topFrequent,
        ]);
    }
}
