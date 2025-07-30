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
    public function run()
    {
        DB::table('units')->insert([
            // General
            ['kode_unit' => '00000', 'nama_unit' => 'General', 'jenis_unit' => 'general', 'created_at' => now(), 'updated_at' => now()],

            // Prodi Kampus Pusat & Lainnya
            ['kode_unit' => '20201', 'nama_unit' => 'TEKNIK ELEKTRO', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '21201', 'nama_unit' => 'TEKNIK MESIN', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '24201', 'nama_unit' => 'TEKNIK KIMIA', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '26201', 'nama_unit' => 'TEKNIK INDUSTRI', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '90101', 'nama_unit' => 'LABORAN', 'jenis_unit' => 'lembaga', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '90102', 'nama_unit' => 'LAINNYA', 'jenis_unit' => 'lembaga', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '61201', 'nama_unit' => 'MANAJEMEN', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '62201', 'nama_unit' => 'AKUNTANSI', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '62302', 'nama_unit' => 'AKUNTANSI PERPAJAKAN', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '62401', 'nama_unit' => 'AKUNTANSI', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '63412', 'nama_unit' => 'ADMINISTRASI PERKANTORAN', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '79201', 'nama_unit' => 'SASTRA INDONESIA', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '79202', 'nama_unit' => 'SASTRA INGGRIS', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '63201', 'nama_unit' => 'ADMINISTRASI NEGARA', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '65201', 'nama_unit' => 'ILMU PEMERINTAHAN', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '74201', 'nama_unit' => 'ILMU HUKUM', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '44201', 'nama_unit' => 'MATEMATIKA', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '45201', 'nama_unit' => 'FISIKA', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '46201', 'nama_unit' => 'BIOLOGI', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '90501', 'nama_unit' => 'LABORAN', 'jenis_unit' => 'lembaga', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '85207', 'nama_unit' => 'PENDIDIKAN JASMANI', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '86206', 'nama_unit' => 'PENDIDIKAN GURU SEKOLAH DASAR', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '86906', 'nama_unit' => 'PENDIDIKAN PROFESI GURU', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '87203', 'nama_unit' => 'PENDIDIKAN EKONOMI', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '87205', 'nama_unit' => 'PENDIDIKAN PANCASILA DAN KEWARGANEGARAAN', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '55101', 'nama_unit' => 'TEKNIK INFORMATIKA S2', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '61101', 'nama_unit' => 'MANAJEMEN', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '62101', 'nama_unit' => 'AKUNTANSI', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '74101', 'nama_unit' => 'ILMU HUKUM', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '86139', 'nama_unit' => 'MANAJEMEN PENDIDIKAN', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '60206', 'nama_unit' => 'EKONOMI SYARIAH', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '86231', 'nama_unit' => 'MANAJEMEN PENDIDIKAN ISLAM', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '55201', 'nama_unit' => 'TEKNIK INFORMATIKA', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '57201', 'nama_unit' => 'SISTEM INFORMASI', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '90901', 'nama_unit' => 'LABORAN', 'jenis_unit' => 'lembaga', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '70201', 'nama_unit' => 'ILMU KOMUNIKASI', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],

            // Prodi Kampus Serang
            ['kode_unit' => '20205', 'nama_unit' => 'TEKNIK ELEKTRO', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '21205', 'nama_unit' => 'TEKNIK MESIN', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '44202', 'nama_unit' => 'MATEMATIKA', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '45202', 'nama_unit' => 'FISIKA', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '46206', 'nama_unit' => 'BIOLOGI', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '47204', 'nama_unit' => 'KIMIA', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '56205', 'nama_unit' => 'SISTEM KOMPUTER', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '57211', 'nama_unit' => 'SISTEM INFORMASI', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '61220', 'nama_unit' => 'MANAJEMEN', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '62210', 'nama_unit' => 'AKUNTANSI', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '63205', 'nama_unit' => 'ADMINISTRASI NEGARA', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '65202', 'nama_unit' => 'ILMU PEMERINTAHAN', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
            ['kode_unit' => '74208', 'nama_unit' => 'ILMU HUKUM', 'jenis_unit' => 'prodi', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
