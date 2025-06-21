<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'nama_pengguna' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 1,
            'unit_id' => 1,
            'role_id' => 1,
        ]);

        User::create([
            'nama_pengguna' => 'Prodi Pusat',
            'email' => 'dosen1@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 2,
            'unit_id' => 4,
            'role_id' => 4,
        ]);

        User::create([
            'nama_pengguna' => 'Prodi Witana',
            'email' => 'dosen2@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 3,
            'unit_id' => 5,
            'role_id' => 4,
        ]);

        User::create([
            'nama_pengguna' => 'Prodi Viktor',
            'email' => 'dosen3@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 4,
            'unit_id' => 3,
            'role_id' => 4,
        ]);

        User::create([
            'nama_pengguna' => 'Prodi Serang',
            'email' => 'dosen4@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 5,
            'unit_id' => 4,
            'role_id' => 4,
        ]);

        User::create([
            'nama_pengguna' => 'Validator Unpam Pusat',
            'email' => 'validatorpusat@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 2,
            'unit_id' => 1,
            'role_id' => 2,
        ]);

        User::create([
            'nama_pengguna' => 'Validator Unpam Witana',
            'email' => 'validatorwitana@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 3,
            'unit_id' => 1,
            'role_id' => 2,
        ]);

        User::create([
            'nama_pengguna' => 'Validator Unpam Viktor',
            'email' => 'validatorviktor@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 4,
            'unit_id' => 1,
            'role_id' => 2,
        ]);

        User::create([
            'nama_pengguna' => 'Validator Unpam Serang',
            'email' => 'validatorserang@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 5,
            'unit_id' => 1,
            'role_id' => 2,
        ]);

        User::create([
            'nama_pengguna' => 'Lembaga Unpam Pusat',
            'email' => 'lembagapusat@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 2,
            'unit_id' => 2,
            'role_id' => 3,
        ]);

        User::create([
            'nama_pengguna' => 'Lembaga Unpam Witana',
            'email' => 'lembagawitana@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 3,
            'unit_id' => 2,
            'role_id' => 3,
        ]);

        User::create([
            'nama_pengguna' => 'Lembaga Unpam Viktor',
            'email' => 'lembagaviktor@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 4,
            'unit_id' => 1,
            'role_id' => 3,
        ]);

        User::create([
            'nama_pengguna' => 'Lembaga Unpam Serang',
            'email' => 'lembagaserang@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 5,
            'unit_id' => 1,
            'role_id' => 3,
        ]);

         User::create([
            'nama_pengguna' => 'Lembaga LSP',
            'email' => 'lsp@example.com',
            'password' => Hash::make('password'),
            'lokasi_id' => 4,
            'unit_id' => 1,
            'role_id' => 3,
        ]);

    }
}
