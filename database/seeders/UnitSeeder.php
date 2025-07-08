<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            //General
            ['kode_unit' => '00000', 'nama_unit' => 'General', 'jenis_unit' => 'genaral', 'created_at' => now(), 'updated_at' => now()],

            // Lembaga
            ['kode_unit' => '209', 'nama_unit' => 'LSP', 'jenis_unit' => 'lembaga', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '210', 'nama_unit' => 'Bahasa', 'jenis_unit' => 'lembaga', 'created_at' => now(), 'updated_at' => now()],

            // Prodi
            ['kode_unit' => '55201', 'nama_unit' => 'Teknik Informatika', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '55204', 'nama_unit' => 'Akuntansi', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '55205', 'nama_unit' => 'Manajemen', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],

            // Umum lainnya
            ['kode_unit' => '55206', 'nama_unit' => 'CBT Center', 'jenis_unit' => 'lembaga', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '55207', 'nama_unit' => 'Laboratorium Terpadu', 'jenis_unit' => 'lembaga', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
