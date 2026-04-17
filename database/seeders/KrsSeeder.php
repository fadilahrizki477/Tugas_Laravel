<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $npmList              = DB::table('mahasiswa')->pluck('npm')->toArray();
        $kodeMatakuliahList   = DB::table('matakuliah')->pluck('kode_matakuliah')->toArray();

        $inserted = []; // untuk menghindari duplikasi npm + kode_matakuliah

        $count = 0;
        $maxAttempts = 100;

        while ($count < 15 && $maxAttempts > 0) {
            $npm             = $faker->randomElement($npmList);
            $kodeMatakuliah  = $faker->randomElement($kodeMatakuliahList);
            $key             = $npm . '_' . $kodeMatakuliah;

            if (!in_array($key, $inserted)) {
                DB::table('krs')->insert([
                    'npm'             => $npm,
                    'kode_matakuliah' => $kodeMatakuliah,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);

                $inserted[] = $key;
                $count++;
            }

            $maxAttempts--;
        }
    }
}
