<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $matakuliahList = [
            'Pemrograman Web',
            'Basis Data',
            'Algoritma dan Pemrograman',
            'Jaringan Komputer',
            'Kecerdasan Buatan',
        ];

        foreach ($matakuliahList as $index => $nama) {
            DB::table('matakuliah')->insert([
                'kode_matakuliah' => 'MK' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'nama_matakuliah' => $nama,
                'sks'             => $faker->randomElement([2, 3, 4]),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
