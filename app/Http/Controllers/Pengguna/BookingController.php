<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\JadwalBooking;
use App\Models\PengajuanBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

    public function diterima()
    {
        return view('pengguna.booking.diterima', [
            'path' => Route::currentRouteName(),
            'page_meta' => [
                'page' => 'Data Booking Diterima',
                'description' => 'Daftar pengajuan booking yang diterima.'
            ]
        ]);
    }

    public function menunggu()
    {
        return view('pengguna.booking.menunggu', [
            'path' => Route::currentRouteName(),
            'page_meta' => [
                'page' => 'Data Booking Menunggu',
                'description' => 'Daftar pengajuan booking yang masih menunggu.'
            ]
        ]);
    }

    public function dibatalkan()
    {
        return view('pengguna.booking.dibatalkan', [
            'path' => Route::currentRouteName(),
            'page_meta' => [
                'page' => 'Data Booking Dibatalkan',
                'description' => 'Daftar pengajuan booking yang dibatalkan.'
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

            $query = PengajuanBooking::with(['jadwalBookings.laboratoriumUnpam', 'user.role']);
            $query->whereIn('status_pengajuan_booking', ['diterima', 'menunggu']);

            if ($role === 'lembaga') {
                $query->whereHas('user.role', function ($q) {
                    $q->where('prioritas_peran', '<=', 3);
                });
            } elseif ($role === 'prodi') {
                $query->whereHas('user.role', function ($q) {
                    $q->where('prioritas_peran', '>=', 3);
                });
            }

            $query->where('lokasi_id', $user->lokasi_id);
            $pengajuanList = $query->get();

            $events = $pengajuanList->flatMap(function ($pengajuan) {
                $isRange = $pengajuan->mode_tanggal_pengajuan === 'range';

                if ($isRange && $pengajuan->jadwalBookings->count() > 1) {
                    // Buat 1 event untuk rentang tanggal
                    $start = $pengajuan->jadwalBookings->min('tanggal_jadwal');
                    $end = Carbon::parse($pengajuan->jadwalBookings->max('tanggal_jadwal'))->addDay(); // end is exclusive

                    $color = match ($pengajuan->status_pengajuan_booking) {
                        'menunggu' => '#9ca3af',
                        'diterima' => '#34d399',
                        default => '#f87171',
                    };

                    return [
                        [
                            'id' => $pengajuan->id,
                            'title' => $pengajuan->user->nama_pengguna . ' - ' . $pengajuan->keperluan_pengajuan_booking . ' - ' . $pengajuan->status_pengajuan_booking,
                            'start' => $start,
                            'end' => $end,
                            'allDay' => true,
                            'color' => $color,
                            'extendedProps' => [
                                'lab' => $pengajuan->jadwalBookings
                                    ->pluck('laboratoriumUnpam.nama_laboratorium')
                                    ->unique()
                                    ->filter()
                                    ->values()
                                    ->all(),
                                'tanggal' => $start,
                                'mode' => 'range',
                                'pemesan' => $pengajuan->user->nama_pengguna ?? 'Tidak diketahui',
                                'role' => $pengajuan->user->role?->nama_peran ?? '-',
                            ],
                        ]
                    ];
                }

                // Bukan rentang → tampilkan satu per tanggal
                return $pengajuan->jadwalBookings->map(function ($jadwal) use ($pengajuan) {
                    $color = match ($pengajuan->status_pengajuan_booking) {
                        'menunggu' => '#9ca3af',
                        'diterima' => '#34d399',
                        default => '#f87171',
                    };

                    return [
                        'id' => $jadwal->id,
                        'title' => $pengajuan->user->nama_pengguna . ' - ' . $pengajuan->keperluan_pengajuan_booking . ' - ' . $pengajuan->status_pengajuan_booking,
                        'start' => $jadwal->tanggal_jadwal,
                        'allDay' => true,
                        'color' => $color,
                        'extendedProps' => [
                            'tanggal' => $jadwal->tanggal_jadwal,
                            'mulai' => $jadwal->jam_mulai,
                            'selesai' => $jadwal->jam_selesai,
                            'lab' => $jadwal->laboratoriumUnpam?->nama_laboratorium ?? '-',
                            'role' => $pengajuan->user->role?->nama_peran ?? '-',
                            'pemesan' => $pengajuan->user->nama_pengguna ?? 'Tidak diketahui',
                            'mode' => 'multi',
                            'jadwal' => $pengajuan->jadwalBookings->map(function ($j) {
                                return [
                                    'tanggal' => $j->tanggal_jadwal,
                                    'mulai' => $j->jam_mulai,
                                    'selesai' => $j->jam_selesai,
                                    'lab' => $j->laboratoriumUnpam?->nama_laboratorium ?? '-',
                                ];
                            }),
                        ],
                    ];
                });

            });



            return response()->json($events->values());
        } catch (\Throwable $e) {
            \Log::error('Calendar API Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
