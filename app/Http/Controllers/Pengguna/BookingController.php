<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\JadwalBooking;
use App\Models\PengajuanBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('pengguna.booking.booking', [
            'page_meta' => [
                'page' => 'Halaman Booking',
                'description' => 'Halaman untuk pengajuan dan jadwal booking.'
            ]
        ]);
    }

    public function getBookingEvents(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user || !$user->role) {
                return response()->json(['error' => 'User or role not found'], 403);
            }

            $role = $user->role->nama_peran;

            $query = PengajuanBooking::with(['jadwalBookings', 'user.role', 'jadwalBookings.pengajuanBooking.user.role'])->whereIn('status_pengajuan_booking', ['diterima', 'menunggu']);
            ;


            if ($role === 'lembaga') {
                $query->whereHas('user.role', function ($q) {
                    $q->where('prioritas_peran', '<=', 3);
                });
            } elseif ($role === 'prodi') {
                $query->whereHas('user.role', function ($q) {
                    $q->where('prioritas_peran', '>=', 3);
                });
            }
            $pengajuanList = $query->get();

            $events = $pengajuanList->map(function ($pengajuan) {
                if ($pengajuan->jadwalBookings->isEmpty())
                    return null;

                $start = $pengajuan->jadwalBookings->min('tanggal_jadwal');
                $end = Carbon::parse($pengajuan->jadwalBookings->max('tanggal_jadwal'))->addDay(); // end is exclusive

                return [
                    'id' => $pengajuan->id,
                    'title' => $pengajuan->user->nama_pengguna . ' - ' . $pengajuan->keperluan_pengajuan_booking,
                    'start' => $start,
                    'end' => $end,
                    'allDay' => true,
                    'color' => '#f87171',
                    'extendedProps' => [
                        'jadwal' => $pengajuan->jadwalBookings->map(function ($jadwal) {
                            return [
                                'tanggal' => $jadwal->tanggal_jadwal,
                                'mulai' => $jadwal->jam_mulai,
                                'selesai' => $jadwal->jam_selesai,
                                'lab' => $jadwal->laboratoriumUnpam?->nama_laboratorium ?? '-',
                                'role' => $jadwal->pengajuanBooking->user->role?->nama_peran ?? '-',
                            ];
                        }),
                        'pemesan' => $pengajuan->user->nama_pengguna ?? 'Tidak diketahui',
                    ],
                ];
            })->filter()->values();

            return response()->json($events);
        } catch (\Throwable $e) {
            \Log::error('Calendar API Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



}
