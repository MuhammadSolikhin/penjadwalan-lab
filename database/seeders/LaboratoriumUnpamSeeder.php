<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaboratoriumUnpamSeeder extends Seeder
{
     public function run(): void
    {
        $labsViktor = [
            ['name' => 'CBT 1', 'unit_id' => 1],
            ['name' => 'CBT 2', 'unit_id' => 1],
            ['name' => 'CBT 3', 'unit_id' => 1],
            ['name' => 'CBT 4', 'unit_id' => 1],
            ['name' => 'CBT 5', 'unit_id' => 1],
            ['name' => 'CBT 6', 'unit_id' => 1],
            ['name' => 'CBT 7', 'unit_id' => 1],
            ['name' => 'CBT 8', 'unit_id' => 1],
            ['name' => 'TI 1', 'unit_id' => 3],
            ['name' => 'TI 2', 'unit_id' => 3],
            ['name' => 'TI 3', 'unit_id' => 3],
            ['name' => 'Jaringan 1', 'unit_id' => 3],
            ['name' => 'Jaringan 2', 'unit_id' => 3],
            ['name' => 'Jaringan 3', 'unit_id' => 3],
            ['name' => 'Elektro 1', 'unit_id' => 7],
            ['name' => 'Elektro 2', 'unit_id' => 7],
            ['name' => 'Elektro 3', 'unit_id' => 7],
            ['name' => 'Multimedia 1', 'unit_id' => 7],
            ['name' => 'Multimedia 2', 'unit_id' => 7],
        ];

        foreach ($labsViktor as $lab) {
            DB::table('laboratorium_unpams')->insert([
                'nama_laboratorium' => $lab['name'],
                'lokasi_id' => 4,
                'unit_id' => $lab['unit_id'],
                'kapasitas_laboratorium' => 25,
                'status_laboratorium' => 'tersedia',
                'jenislab_id' => 1,
                'deskripsi_laboratorium' => "Laboratorium {$lab['name']} digunakan untuk praktikum dan ujian.",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $lokasiTambahan = [
            1 => 'fleksible',
            2 => 'pusat',
            3 => 'witana',
            5 => 'serang',
        ];

        foreach ($lokasiTambahan as $id => $nama) {
            for ($i = 1; $i <= 10; $i++) {
                DB::table('laboratorium_unpams')->insert([
                    'nama_laboratorium' => "Lab $nama $i",
                    'lokasi_id' => $id,
                    'unit_id' => rand(3, 7),
                    'kapasitas_laboratorium' => rand(15, 35),
                    'status_laboratorium' => 'tersedia',
                    'jenislab_id' => rand(1, 4),
                    'deskripsi_laboratorium' => "Laboratorium di lokasi $nama nomor $i.",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
