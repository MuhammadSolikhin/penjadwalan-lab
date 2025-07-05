<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'nama',
        'spesifikasi',
        'deskripsi',
        'status',
        'kategori_barang_id',
        'lab_id',
        'meja_id',
    ];

    public function kategoriBarang()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }

    public function laboratoriumUnpam()
    {
        return $this->belongsTo(LaboratoriumUnpam::class, 'lab_id');
    }

    public function meja()
    {
        return $this->belongsTo(Barang::class, 'meja_id');
    }
}
