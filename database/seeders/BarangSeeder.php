<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\LaboratoriumUnpam;
use App\Models\KategoriBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua laboratorium
        $labs = LaboratoriumUnpam::all();
        $kategoriKomputer = KategoriBarang::where('nama', 'Komputer')->first();

        if (!$kategoriKomputer) {
            throw new \Exception('Kategori "Komputer" tidak ditemukan. Pastikan seeder kategori sudah dijalankan.');
        }

        foreach ($labs as $lab) {
            $total = rand(25, 30);
            $rusakCount = rand(1, 5);
            $digunakanCount = $total - $rusakCount;

            // Barang digunakan
            for ($i = 1; $i <= $digunakanCount; $i++) {
                DB::table('barangs')->insert([
                    'nama' => "Komputer {$i} - {$lab->nama}",
                    'spesifikasi' => "CPU Intel i5, RAM 8GB, SSD 256GB",
                    'deskripsi' => "Komputer lab {$lab->nama} digunakan untuk praktikum.",
                    'status' => 'digunakan',
                    'kategori_barang_id' => $kategoriKomputer->id,
                    'lab_id' => $lab->id,
                    'meja_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Barang rusak
            for ($j = 1; $j <= $rusakCount; $j++) {
                DB::table('barangs')->insert([
                    'nama' => "Komputer Rusak {$j} - {$lab->nama}",
                    'spesifikasi' => "CPU Intel i3, RAM 4GB, HDD 500GB",
                    'deskripsi' => "Komputer rusak di lab {$lab->nama}.",
                    'status' => 'rusak',
                    'kategori_barang_id' => $kategoriKomputer->id,
                    'lab_id' => $lab->id,
                    'meja_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
