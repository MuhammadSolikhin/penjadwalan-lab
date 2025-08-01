<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Makin Kecil makin tinggi prioritasnya

        Roles::create([
            'nama_peran' => 'admin',
            'prioritas_peran' => 1
        ]);

        Roles::create([
            'nama_peran' => 'laboran',
            'prioritas_peran' => 2
        ]);

        Roles::create([
            'nama_peran' => 'lembaga',
            'prioritas_peran' => 3
        ]);

        Roles::create([
            'nama_peran' => 'prodi',
            'prioritas_peran' => 4
        ]);

        Roles::create([
            'nama_peran' => 'user',
            'prioritas_peran' => 5
        ]);
    }
}
