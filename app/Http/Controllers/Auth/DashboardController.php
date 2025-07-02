<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\JadwalBooking;
use App\Models\LaboratoriumUnpam;
use App\Models\PengajuanBooking;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        // Total User
        $usersCount = User::all()->count();

        // Total All Laboratorium
        $laboratoryCount = LaboratoriumUnpam::all()->count();

        // Total all schedules and schedules per building
        $schedulesCount = JadwalBooking::all()->count();
        $counts = [];
        for ($i = 0; $i < 5; $i++) {
            # code...
            $counts[$i] = JadwalBooking::with('laboratoriumUnpam')->whereRelation('laboratoriumUnpam', 'lokasi_id', '=', ($i + 2))->count();
        }

        // Top frequent user
        $topFrequent = User::withCount('jadwalBookings')
            ->orderByDesc('jadwal_bookings_count')
            ->limit(5)
            ->get();

        return view("admin.index", [
            'usersCount' => $usersCount,
            'laboratoryCount' => $laboratoryCount,
            'schedulesCount' => $schedulesCount,
            'pusatCount' => $counts[0],
            'witanaCount' => $counts[1],
            'viktorCount' => $counts[2],
            'serangCount' => $counts[3],
            'topFrequent' => $topFrequent
        ]);
    }

    public function laboran()
    {
        // Total User
        $usersCount = User::all()->count();

        // Total All Laboratorium
        $laboratoryCount = LaboratoriumUnpam::all()->count();

        // Total all schedules and schedules per building
        $schedulesCount = JadwalBooking::all()->count();
        $counts = [];
        for ($i = 0; $i < 5; $i++) {
            # code...
            $counts[$i] = JadwalBooking::with('laboratoriumUnpam')->whereRelation('laboratoriumUnpam', 'lokasi_id', '=', ($i + 2))->count();
        }

        // Top frequent user
        $topFrequent = User::withCount('jadwalBookings')
            ->orderByDesc('jadwal_bookings_count')
            ->limit(5)
            ->get();
        return view("laboran.index", [
            'usersCount' => $usersCount,
            'laboratoryCount' => $laboratoryCount,
            'schedulesCount' => $schedulesCount,
            'pusatCount' => $counts[0],
            'witanaCount' => $counts[1],
            'viktorCount' => $counts[2],
            'serangCount' => $counts[3],
            'topFrequent' => $topFrequent
        ]);
    }

    public function dashboardPengguna()
    {
        // Total All Laboratorium
        $laboratoryCount = LaboratoriumUnpam::all()->count();

        // Total all schedules and schedules per building
        $schedulesCount = JadwalBooking::all()->count();
        $counts = [];
        for ($i = 0; $i < 5; $i++) {
            # code...
            $counts[$i] = JadwalBooking::with('laboratoriumUnpam')->whereRelation('laboratoriumUnpam', 'lokasi_id', '=', ($i + 2))->count();
        }

        // Top frequent user
        $topFrequent = User::withCount('jadwalBookings')
            ->orderByDesc('jadwal_bookings_count')
            ->limit(5)
            ->get();

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
            'reservations' => $reservations
        ]);
    }
}
