<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\JadwalBooking;
use App\Models\LaboratoriumUnpam;
use App\Models\PengajuanBooking;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        // Total User
        $usersCount = User::all()->count();

        // Total All Laboratorium
        $laboratory = LaboratoriumUnpam::all();

        $availableLaboratoryCount = $laboratory->filter(function ($laboratorium) {
            return $laboratorium->status_laboratorium == 1; // Assuming 1 means available
        })->count();
        $brokenLaboratoryCount = $laboratory->filter(function ($laboratorium) {
            return $laboratorium->status_laboratorium == 0; // Assuming 2 means broken
        })->count();

        // Get past 3 years schedule data
        $threeYearsAgo = Carbon::now()->subYears(3);
        $threeYearSchedules = JadwalBooking::with('laboratoriumUnpam')->where('status', '=', 'diterima')->where('created_at', '>=', $threeYearsAgo)->get();

        // Get current period schedules
        $currentSchedules = $threeYearSchedules->filter(function ($item) {
            $itemDate = \Carbon\Carbon::parse($item->created_at);
            $currentDate = now();
            $currentPeriod = $currentDate->month <= 6 ? 1 : 2;

            if ($currentPeriod == 2) {
                return $itemDate->year == $currentDate->year && $itemDate->month > 6;
            } else {
                return $itemDate->year == $currentDate->year && $itemDate->month <= 6;
            }
        });

        // Total all schedules and schedules per building
        $counts = [];
        for ($i = 0; $i < 5; $i++) {
            $location_id = $i + 2;
            $counts[$i] = $currentSchedules->filter(function ($item) use ($location_id) {
                return $item->laboratoriumUnpam->lokasi_id ==  $location_id;
            })->count();
        }

        // Schedules by Periods
        $grouped = collect();

        foreach ($threeYearSchedules as $item) {
            $date = \Carbon\Carbon::parse($item->created_at);
            $year = $date->year;
            $semester = $date->month <= 6 ? 1 : 2;
            $period = "{$year}-{$semester}";

            $grouped->put($period, $grouped->get($period, 0) + 1);
        }

        // Get 6 recent periods
        $sorted = $grouped->sortKeysDesc()->slice(0, 6)->sortKeys();

        $schedulesbyPeriod = [
            'labels' => $sorted->keys()->values(),
            'data'   => $sorted->values(),
        ];

        // Top frequent user
        $currentDate = now();
        if ($currentDate->month < 7) {
            $startDate = Carbon::create($currentDate->year, 1, 1)->startOfDay();
            $endDate = Carbon::create($currentDate->year, 6, 30)->endOfDay();
        } else {
            $startDate = Carbon::create($currentDate->year, 7, 1)->startOfDay();
            $endDate = Carbon::create($currentDate->year, 12, 31)->endOfDay();
        }

        $topFrequent = User::withCount(['jadwalBookings as jadwal_bookings_count' => function ($query) use ($startDate, $endDate) {
            $query->where('status', '=', 'diterima')->whereBetween('jadwal_bookings.created_at', [$startDate, $endDate]);
        }])
            ->orderByDesc('jadwal_bookings_count')
            ->limit(5)
            ->get();

        // Total Computer
        $computerCount = Barang::where('nama', "LIKE", "komputer%")->count();

        return view("admin.index", [
            'usersCount' => $usersCount,
            'laboratoryCount' => $laboratory->count(),
            'availableLab' => $availableLaboratoryCount,
            'brokenLab' => $brokenLaboratoryCount,
            'schedulesCount' => $currentSchedules->count(),
            'pusatCount' => $counts[0],
            'witanaCount' => $counts[1],
            'viktorCount' => $counts[2],
            'serangCount' => $counts[3],
            'schedulesbyPeriod' => $schedulesbyPeriod,
            'topFrequent' => $topFrequent,
            'computerCount' => $computerCount
        ]);
    }

    public function laboran()
    {
        // Total User
        $usersCount = User::all()->count();

        // Total All Laboratorium
        $laboratory = LaboratoriumUnpam::all();

        $availableLaboratoryCount = $laboratory->filter(function ($laboratorium) {
            return $laboratorium->status_laboratorium == 1; // Assuming 1 means available
        })->count();
        $brokenLaboratoryCount = $laboratory->filter(function ($laboratorium) {
            return $laboratorium->status_laboratorium == 0; // Assuming 2 means broken
        })->count();

        // Get past 3 years schedule data
        $threeYearsAgo = Carbon::now()->subYears(3);
        $threeYearSchedules = JadwalBooking::with('laboratoriumUnpam')->where('status', '=', 'diterima')->where('created_at', '>=', $threeYearsAgo)->get();

        // Get current period schedules
        $currentSchedules = $threeYearSchedules->filter(function ($item) {
            $itemDate = \Carbon\Carbon::parse($item->created_at);
            $currentDate = now();
            $currentPeriod = $currentDate->month <= 6 ? 1 : 2;

            if ($currentPeriod == 2) {
                return $itemDate->year == $currentDate->year && $itemDate->month > 6;
            } else {
                return $itemDate->year == $currentDate->year && $itemDate->month <= 6;
            }
        });

        // Total all schedules and schedules per building
        $counts = [];
        for ($i = 0; $i < 5; $i++) {
            $location_id = $i + 2;
            $counts[$i] = $currentSchedules->filter(function ($item) use ($location_id) {
                return $item->laboratoriumUnpam->lokasi_id ==  $location_id;
            })->count();
        }

        // Schedules by Periods
        $grouped = collect();

        foreach ($threeYearSchedules as $item) {
            $date = \Carbon\Carbon::parse($item->created_at);
            $year = $date->year;
            $semester = $date->month <= 6 ? 1 : 2;
            $period = "{$year}-{$semester}";

            $grouped->put($period, $grouped->get($period, 0) + 1);
        }

        // Get 6 recent periods
        $sorted = $grouped->sortKeysDesc()->slice(0, 6)->sortKeys();

        $schedulesbyPeriod = [
            'labels' => $sorted->keys()->values(),
            'data'   => $sorted->values(),
        ];

        // Get Period
        $currentDate = now();
        if ($currentDate->month < 7) {
            $startDate = Carbon::create($currentDate->year, 1, 1)->startOfDay();
            $endDate = Carbon::create($currentDate->year, 6, 30)->endOfDay();
        } else {
            $startDate = Carbon::create($currentDate->year, 7, 1)->startOfDay();
            $endDate = Carbon::create($currentDate->year, 12, 31)->endOfDay();
        }

        // Top frequent user
        $topFrequent = User::withCount(['jadwalBookings as jadwal_bookings_count' => function ($query) use ($startDate, $endDate) {
            $query->where('status', '=', 'diterima')->whereBetween('jadwal_bookings.created_at', [$startDate, $endDate]);
        }])
            ->orderByDesc('jadwal_bookings_count')
            ->limit(5)
            ->get();

        // Total Computer
        $computerCount = Barang::where('nama', "LIKE", "komputer%")->count();

        return view("laboran.index", [
            'usersCount' => $usersCount,
            'laboratoryCount' => $laboratory->count(),
            'availableLab' => $availableLaboratoryCount,
            'brokenLab' => $brokenLaboratoryCount,
            'schedulesCount' => $currentSchedules->count(),
            'pusatCount' => $counts[0],
            'witanaCount' => $counts[1],
            'viktorCount' => $counts[2],
            'serangCount' => $counts[3],
            'schedulesbyPeriod' => $schedulesbyPeriod,
            'topFrequent' => $topFrequent,
            'computerCount' => $computerCount
        ]);
    }

    public function dashboardPengguna()
    {
        // Total All Laboratorium
        $laboratory = LaboratoriumUnpam::all();

        $availableLaboratoryCount = $laboratory->filter(function ($laboratorium) {
            return $laboratorium->status_laboratorium == 1; // Assuming 1 means available
        })->count();
        $brokenLaboratoryCount = $laboratory->filter(function ($laboratorium) {
            return $laboratorium->status_laboratorium == 0; // Assuming 0 means broken
        })->count();

        // Get period
        $currentDate = now();
        if ($currentDate->month < 7) {
            $startDate = Carbon::create($currentDate->year, 1, 1)->startOfDay();
            $endDate = Carbon::create($currentDate->year, 6, 30)->endOfDay();
        } else {
            $startDate = Carbon::create($currentDate->year, 7, 1)->startOfDay();
            $endDate = Carbon::create($currentDate->year, 12, 31)->endOfDay();
        }

        // Total all schedules and schedules per building
        $currentSchedules = JadwalBooking::with('laboratoriumUnpam')->where('status', '=', 'diterima')->whereBetween('created_at', [$startDate, $endDate])->get();
        $counts = [];
        for ($i = 0; $i < 5; $i++) {
            $location_id = $i + 2;
            $counts[$i] = $currentSchedules->filter(function ($item) use ($location_id) {
                return $item->laboratoriumUnpam->lokasi_id ==  $location_id;
            })->count();
        }

        // Top frequent user
        $topFrequent = User::withCount(['jadwalBookings as jadwal_bookings_count' => function ($query) use ($startDate, $endDate) {
            $query->where('status', '=', 'diterima')->whereBetween('jadwal_bookings.created_at', [$startDate, $endDate]);
        }])
            ->orderByDesc('jadwal_bookings_count')
            ->limit(5)
            ->get();

        // Total Computer
        $computerCount = Barang::where('nama', "LIKE", "komputer%")->count();

        // Available schedule for 1 semester
        $period = $currentDate->month < 7 ? CarbonPeriod::create($currentDate, "{$currentDate->year}-06-30") : CarbonPeriod::create($currentDate, "$currentDate->year-12-31");
        $totalDays = $period->count();
        $possibleSchedules = 5 * $totalDays * $laboratory->count();     // 5 hours per day * remaining of days in 1 semester * number of labs
        $availableSchedules = $possibleSchedules - $currentSchedules->count();

        // User reservation
        $reservations = PengajuanBooking::with('laboratorium.lokasi')->where('user_id', '=', Auth::user()->id)->get();

        return view("pengguna.index", [
            'laboratoryCount' => $laboratory->count(),
            'availableLab' => $availableLaboratoryCount,
            'brokenLab' => $brokenLaboratoryCount,
            'schedulesCount' => $currentSchedules->count(),
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
