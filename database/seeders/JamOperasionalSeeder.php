<?php

namespace Database\Seeders;

use App\Models\HariOperasional;
use App\Models\JamOperasional;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JamOperasionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jamKuliah = [
            // Senin, Selasa, Rabu, Jumat
            'default' => [
                ['07:10:00', '08:50:00'],
                ['08:50:00', '10:30:00'],
                ['10:30:00', '12:10:00'],
                ['13:00:00', '14:40:00'],
                ['14:40:00', '16:20:00'],
                ['18:20:00', '20:00:00'],
                ['20:00:00', '21:40:00'],
            ],
            // Kamis & Sabtu
            'khusus' => [
                ['07:40:00', '09:20:00'],
                ['09:20:00', '11:00:00'],
                ['11:00:00', '13:50:00'],
                ['13:50:00', '15:30:00'],
                ['16:00:00', '17:40:00'],
            ],
        ];

        $hariOperasionals = HariOperasional::all();

        foreach ($hariOperasionals as $hari) {
            $dayNumber = (int) $hari->hari_operasional;

            // Tentukan jenis jadwal
            if (in_array($dayNumber, [4, 6])) { // 4 = Kamis, 6 = Sabtu
                $jamList = $jamKuliah['khusus'];
            } elseif (in_array($dayNumber, [1, 2, 3, 5])) { // Senin, Selasa, Rabu, Jumat
                $jamList = $jamKuliah['default'];
            } else {
                continue; // Minggu atau tidak terdaftar
            }

            foreach ($jamList as [$mulai, $selesai]) {
                JamOperasional::create([
                    'hari_operasional_id' => $hari->id,
                    'jam_mulai' => $mulai,
                    'jam_selesai' => $selesai,
                    'is_disabled' => false,
                ]);
            }
        }
    }
}
