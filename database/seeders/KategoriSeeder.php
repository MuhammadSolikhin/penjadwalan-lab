<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Komputer',
                'deskripsi' => 'Unit komputer lengkap termasuk CPU, monitor, keyboard, dan mouse.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Laptop',
                'deskripsi' => 'Laptop untuk keperluan praktikum atau mobile computing.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jaringan',
                'deskripsi' => 'Perangkat jaringan seperti switch, router, modem, dan kabel LAN.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Proyektor',
                'deskripsi' => 'Alat proyeksi visual untuk presentasi dan pembelajaran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Printer & Scanner',
                'deskripsi' => 'Peralatan cetak dan pemindai dokumen untuk kebutuhan lab.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Komponen Hardware',
                'deskripsi' => 'Komponen komputer seperti RAM, harddisk, power supply, motherboard.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Perangkat Lunak',
                'deskripsi' => 'Lisensi software, sistem operasi, dan aplikasi yang digunakan dalam lab.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Meja & Kursi',
                'deskripsi' => 'Fasilitas pendukung seperti meja komputer, kursi ergonomis, dll.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('kategori_barangs')->insert($data);
    }

}
