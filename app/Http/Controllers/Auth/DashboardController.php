<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\JadwalBooking;
use App\Models\LaboratoriumUnpam;
use App\Models\PengajuanBooking;
use App\Models\User;

class DashboardController extends Controller
{
    public function admin()
    {
        // Total User
        $usersCount = User::all()->count();

        // Total All Laboratorium
        $laboratoryCount = LaboratoriumUnpam::all()->count();

        // Total all schedules and schedules per building
        $schedulesCount = JadwalBooking::where('status', '=', 'diterima')->count();
        $counts = [];
        for ($i = 0; $i < 5; $i++) {
            # code...
            $counts[$i] = JadwalBooking::with('laboratoriumUnpam')->whereRelation('laboratoriumUnpam', 'lokasi_id', '=', ($i + 2))->where('status', '=', 'diterima')->count();
        }

        // Top frequent user
       $topFrequent = User::withCount(['jadwalBookings as jadwal_bookings_count' => function ($query){
            $query->where('status', '=', 'diterima');
        }])
            ->orderByDesc('jadwal_bookings_count')
            ->limit(5)
            ->get();

        // Total Computer
        $computerCount = Barang::where('nama', "LIKE", "komputer%")->count();

        return view("admin.index", [
            'usersCount' => $usersCount,
            'laboratoryCount' => $laboratoryCount,
            'schedulesCount' => $schedulesCount,
            'pusatCount' => $counts[0],
            'witanaCount' => $counts[1],
            'viktorCount' => $counts[2],
            'serangCount' => $counts[3],
            'topFrequent' => $topFrequent,
            'computerCount' => $computerCount
        ]);
    }

    public function laboran()
    {
        // Total User
        $usersCount = User::all()->count();

        // Total All Laboratorium
        $laboratoryCount = LaboratoriumUnpam::all()->count();

        // Total all schedules and schedules per building
        $schedulesCount = JadwalBooking::where('status', '=', 'diterima')->count();
        $counts = [];
        for ($i = 0; $i < 5; $i++) {
            # code...
            $counts[$i] = JadwalBooking::with('laboratoriumUnpam')->whereRelation('laboratoriumUnpam', 'lokasi_id', '=', ($i + 2))->where('status', '=', 'diterima')->count();
        }

        // Top frequent user
        $topFrequent = User::withCount(['jadwalBookings as jadwal_bookings_count' => function ($query){
            $query->where('status', '=', 'diterima');
        }])
            ->orderByDesc('jadwal_bookings_count')
            ->limit(5)
            ->get();

        // Total Computer
        $computerCount = Barang::where('nama', "LIKE", "komputer%")->count();

        return view("laboran.index", [
            'usersCount' => $usersCount,
            'laboratoryCount' => $laboratoryCount,
            'schedulesCount' => $schedulesCount,
            'pusatCount' => $counts[0],
            'witanaCount' => $counts[1],
            'viktorCount' => $counts[2],
            'serangCount' => $counts[3],
            'topFrequent' => $topFrequent,
            'computerCount' => $computerCount
        ]);
    }

    public function dashboardPengguna()
    {
        // Total All Laboratorium
        $laboratoryCount = LaboratoriumUnpam::all()->count();

        // Total all schedules and schedules per building
        $schedulesCount = JadwalBooking::where('status', '=', 'diterima')->count();
        $counts = [];
        for ($i = 0; $i < 5; $i++) {
            # code...
            $counts[$i] = JadwalBooking::with('laboratoriumUnpam')->whereRelation('laboratoriumUnpam', 'lokasi_id', '=', ($i + 2))->where('status', '=', 'diterima')->count();
        }

        // Top frequent user
        $topFrequent = User::withCount(['jadwalBookings as jadwal_bookings_count' => function ($query){
            $query->where('status', '=', 'diterima');
        }])
            ->orderByDesc('jadwal_bookings_count')
            ->limit(5)
            ->get();

        // Total Computer
        $computerCount = Barang::where('nama', "LIKE", "komputer%")->count();

        // Available schedule for 1 semester
        $possibleSchedules = 5 * 30 * 6 * 59;     // 5 hours per day * 30 days per month * 6 months * 59 of labs
        $availableSchedules = $possibleSchedules - $schedulesCount;

        // User reservation
        $reservations = PengajuanBooking::with('laboratorium.lokasi')->where('user_id', '=', auth()->id())->get();

        return view("pengguna.index", [
            'laboratoryCount' => $laboratoryCount,
            'schedulesCount' => $schedulesCount,
            'availableSchedules' => $availableSchedules,
            'pusatCount' => $counts[0],
            'witanaCount' => $counts[1],
            'viktorCount' => $counts[2],
            'serangCount' => $counts[3],
            'topFrequent' => $topFrequent,
            'computerCount' => $computerCount,
            'reservations' => $reservations
        ]);
    }
}
