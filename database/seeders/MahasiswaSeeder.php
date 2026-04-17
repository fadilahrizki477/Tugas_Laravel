<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // Ambil semua nidn yang ada di tabel dosen
        $nidnList = DB::table('dosen')->pluck('nidn')->toArray();

        for ($i = 0; $i < 10; $i++) {
            DB::table('mahasiswa')->insert([
                'npm'        => $faker->unique()->numerify('##########'),
                'nidn'       => $faker->randomElement($nidnList),
                'nama'       => $faker->name(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
