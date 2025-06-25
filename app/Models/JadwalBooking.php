<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalBooking extends Model
{
    protected $fillable = [
        'tanggal_jadwal',
        'jam_mulai',
        'jam_selesai',
        'status',
        'pengajuan_booking_id',
        'laboratorium_unpam_id',
    ];

    public function pengajuanBooking()
    {
        return $this->belongsTo(PengajuanBooking::class);
    }

    public function laboratoriumUnpam()
    {
        return $this->belongsTo(LaboratoriumUnpam::class);
    }

    public function pembatalanJadwals()
    {
        return $this->hasMany(PembatalanJadwal::class);
    }

    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            PengajuanBooking::class,
            'id',           // foreign key di PengajuanBooking
            'id',           // foreign key di User
            'pengajuan_booking_id', // local key di JadwalBooking
            'user_id'       // local key di PengajuanBooking
        );
    }

}
