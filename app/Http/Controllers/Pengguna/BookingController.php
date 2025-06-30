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
