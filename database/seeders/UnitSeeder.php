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
            // Lembaga
            ['nama_unit' => 'LSP', 'jenis_unit' => 'lembaga', 'created_at' => now(), 'updated_at' => now()],
            ['nama_unit' => 'Bahasa', 'jenis_unit' => 'lembaga', 'created_at' => now(), 'updated_at' => now()],

            // Prodi
            ['nama_unit' => 'Teknik Informatika', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_unit' => 'Akuntansi', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_unit' => 'Manajemen', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],

            // Umum lainnya
            ['nama_unit' => 'CBT Center', 'jenis_unit' => 'lembaga', 'created_at' => now(), 'updated_at' => now()],
            ['nama_unit' => 'Laboratorium Terpadu', 'jenis_unit' => 'lembaga', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
