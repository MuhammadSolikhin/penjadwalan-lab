<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_barang_id');
    }
}
