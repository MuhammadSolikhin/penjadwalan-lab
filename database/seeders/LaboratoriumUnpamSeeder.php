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

        $kodeCounter = 1;

        foreach ($labsViktor as $lab) {
            DB::table('laboratorium_unpams')->insert([
                'nama_laboratorium' => $lab['name'],
                'kode_laboratorium' => 'LAB-' . str_pad($kodeCounter++, 4, '0', STR_PAD_LEFT),
                'lokasi_id' => 4,
                'unit_id' => $lab['unit_id'],
                'kapasitas_laboratorium' => 25,
                'tipelab' => $lab['unit_id'] == 1 ? 1 : 0,
                'jenislab_id' => 1,
                'deskripsi_laboratorium' => "Laboratorium {$lab['name']} digunakan untuk praktikum dan ujian.",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $generalLabs = [
            3 => 'witana',
            5 => 'serang',
            2 => 'pusat',
        ];

        foreach ($generalLabs as $lokasiId => $namaLokasi) {
            for ($i = 1; $i <= 3; $i++) {
                DB::table('laboratorium_unpams')->insert([
                    'nama_laboratorium' => "General Lab $namaLokasi $i",
                    'kode_laboratorium' => 'LAB-' . str_pad($kodeCounter++, 4, '0', STR_PAD_LEFT),
                    'lokasi_id' => $lokasiId,
                    'unit_id' => 1,
                    'kapasitas_laboratorium' => 30,
                    'tipelab' => 1,
                    'status_laboratorium' => 1, // 1 = tersedia
                    'jenislab_id' => 1,
                    'deskripsi_laboratorium' => "Laboratorium general di lokasi $namaLokasi nomor $i.",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

    }
}
