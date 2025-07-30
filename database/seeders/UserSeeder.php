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

        // Data users (nama_pengguna, email_prefix, unit_id, lokasi_id, role_id)
        $usersData = [
            // General User
            ['Pengguna General', 'general', 1, 1, 2], // Asumsi role_id 2 untuk admin/general

            // Users Kampus Pusat
            ['Prodi Teknik Elektro', 'elektro_pusat', 2, 2, 4],
            ['Prodi Teknik Mesin', 'mesin_pusat', 3, 2, 4],
            ['Prodi Teknik Kimia', 'kimia_pusat', 4, 2, 4],
            ['Prodi Teknik Industri', 'industri_pusat', 5, 2, 4],
            ['Lembaga Laboran 1', 'laboran1', 6, 2, 3],
            ['Lembaga Lainnya', 'lainnya', 7, 2, 3],
            ['Prodi Manajemen S1', 'manajemen_s1_pusat', 8, 2, 4],
            ['Prodi Akuntansi S1', 'akuntansi_s1_pusat', 9, 2, 4],
            ['Prodi Akuntansi Perpajakan', 'akuntansi_pajak', 10, 2, 4],
            ['Prodi Akuntansi D3', 'akuntansi_d3_pusat', 11, 2, 4],
            ['Prodi Administrasi Perkantoran', 'adper', 12, 2, 4],
            ['Prodi Sastra Indonesia', 'sastra_indonesia', 13, 2, 4],
            ['Prodi Sastra Inggris', 'sastra_inggris', 14, 2, 4],
            ['Prodi Administrasi Negara S1', 'adneg_s1_pusat', 15, 2, 4],
            ['Prodi Ilmu Pemerintahan S1', 'ip_s1_pusat', 16, 2, 4],
            ['Prodi Ilmu Hukum S1', 'hukum_s1_pusat', 17, 2, 4],
            ['Prodi Matematika S1', 'matematika_s1_pusat', 18, 2, 4],
            ['Prodi Fisika', 'fisika_pusat', 19, 2, 4],
            ['Prodi Biologi', 'biologi_pusat', 20, 2, 4],
            ['Lembaga Laboran 2', 'laboran2', 21, 2, 3],
            ['Prodi Pendidikan Jasmani', 'penjas', 22, 2, 4],
            ['Prodi PGSD', 'pgsd', 23, 2, 4],
            ['Prodi PPG', 'ppg', 24, 2, 4],
            ['Prodi Pendidikan Ekonomi', 'pend_ekonomi', 25, 2, 4],
            ['Prodi PPKN', 'ppkn', 26, 2, 4],
            ['Prodi Teknik Informatika S2', 'informatika_s2', 27, 2, 4],
            ['Prodi Manajemen S2', 'manajemen_s2', 28, 2, 4],
            ['Prodi Akuntansi S2', 'akuntansi_s2', 29, 2, 4],
            ['Prodi Ilmu Hukum S2', 'hukum_s2', 30, 2, 4],
            ['Prodi Manajemen Pendidikan S2', 'manajemen_pend_s2', 31, 2, 4],
            ['Prodi Ekonomi Syariah', 'ekonomi_syariah', 32, 2, 4],
            ['Prodi Manajemen Pendidikan Islam', 'manajemen_pend_islam', 33, 2, 4],
            ['Prodi Teknik Informatika S1', 'informatika_s1_pusat', 34, 2, 4],
            ['Prodi Sistem Informasi S1', 'si_s1_pusat', 35, 2, 4],
            ['Lembaga Laboran 3', 'laboran3', 36, 2, 3],
            ['Prodi Ilmu Komunikasi', 'ilkom', 37, 2, 4],

            // Users Kampus Serang
            ['Prodi Teknik Elektro Serang', 'elektro_serang', 38, 5, 4],
            ['Prodi Teknik Mesin Serang', 'mesin_serang', 39, 5, 4],
            ['Prodi Matematika Serang', 'matematika_serang', 40, 5, 4],
            ['Prodi Fisika Serang', 'fisika_serang', 41, 5, 4],
            ['Prodi Biologi Serang', 'biologi_serang', 42, 5, 4],
            ['Prodi Kimia Serang', 'kimia_serang', 43, 5, 4],
            ['Prodi Sistem Komputer Serang', 'siskom_serang', 44, 5, 4],
            ['Prodi Sistem Informasi Serang', 'si_serang', 45, 5, 4],
            ['Prodi Manajemen Serang', 'manajemen_serang', 46, 5, 4],
            ['Prodi Akuntansi Serang', 'akuntansi_serang', 47, 5, 4],
            ['Prodi Administrasi Negara Serang', 'adneg_serang', 48, 5, 4],
            ['Prodi Ilmu Pemerintahan Serang', 'ip_serang', 49, 5, 4],
            ['Prodi Ilmu Hukum Serang', 'hukum_serang', 50, 5, 4],
        ];

        foreach ($usersData as $userData) {
            User::create([
                'nama_pengguna' => $userData[0],
                'email' => $userData[1] . '@example.com',
                'password' => Hash::make('password'),
                'unit_id' => $userData[2],
                'lokasi_id' => $userData[3],
                'role_id' => $userData[4],
            ]);
        }

    }
}
