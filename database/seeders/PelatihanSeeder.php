<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Diklat Intelijen Tingkat Dasar',
                'kode' => 'diklat_intelijen_tingkat_dasar',
            ],
            [
                'nama' => 'Diklat Intelijen Tingkat I',
                'kode' => 'diklat_intelijen_tingkat_i',
            ],
            [
                'nama' => 'Diklat Intelijen Tingkat II',
                'kode' => 'diklat_intelijen_tingkat_ii',
            ],
            [
                'nama' => 'Diklat Intelijen Strategis',
                'kode' => 'diklat_intelijen_strategis',
            ],
            [
                'nama' => 'Teknis Intelijen I',
                'kode' => 'teknis_intelijen_i',
            ],
            [
                'nama' => 'Teknis Intelijen II',
                'kode' => 'teknis_intelijen_ii',
            ],
            [
                'nama' => 'Teknis Intelijen III',
                'kode' => 'teknis_intelijen_iii',
            ]
        ];

        foreach ($data as $pelatihan) {
            \App\Models\Pelatihan::create($pelatihan);
        }

    }
}
