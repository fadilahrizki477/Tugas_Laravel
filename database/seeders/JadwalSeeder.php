<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $kodeMatakuliahList = DB::table('matakuliah')->pluck('kode_matakuliah')->toArray();
        $nidnList           = DB::table('dosen')->pluck('nidn')->toArray();
        $kelasList          = ['A', 'B', 'C'];
        $hariList           = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jamList            = ['07:00:00', '08:50:00', '10:40:00', '13:00:00', '14:50:00'];

        for ($i = 0; $i < 8; $i++) {
            DB::table('jadwal')->insert([
                'kode_matakuliah' => $faker->randomElement($kodeMatakuliahList),
                'nidn'            => $faker->randomElement($nidnList),
                'kelas'           => $faker->randomElement($kelasList),
                'hari'            => $faker->randomElement($hariList),
                'jam'             => '2024-01-01 ' . $faker->randomElement($jamList),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
