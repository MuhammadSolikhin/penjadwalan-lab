<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProsesPengajuanBookingController extends Controller
{
    public function index()
    {
        return view("laboran.proses-pengajuan-booking.proses-pengajuan-booking", [
            'path' => Route::currentRouteName(),
            'page_meta' => [
                'page' => 'Proses Pengajuan Booking',
                'description' => 'Halaman Proses Pengajuan Booking.'
            ]
        ]);
    }
}
