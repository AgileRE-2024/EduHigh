<?php

namespace Database\Seeders;

use App\Models\ProposalCriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProposalCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $criteria = [
            [
                'name' => 'Kejelasan Penulisan dan Bahasa',
                'weight' => 10.00,
                'type' => 'material',
            ],
            [
                'name' => 'Kebenaran Materi Keilmuan/Pustaka',
                'weight' => 20.00,
                'type' => 'material',
            ],
            [
                'name' => 'Metode Penelitian',
                'weight' => 20.00,
                'type' => 'material',
            ],
            [
                'name' => 'Sistematika Penyajian dan Penggunaan Alat Peraga (OHP, Papan Tulis, Pengeras Suara) & Ketepatan Waktu Presentasi',
                'weight' => 10.00,
                'type' => 'presentation',
            ],
            [
                'name' => 'Penampilan dan Sikap',
                'weight' => 10.00,
                'type' => 'presentation',
            ],
            [
                'name' => 'Penguasaan Materi dan Ketepatan Jawaban atas Pertanyaan yang Diajukan',
                'weight' => 30.00,
                'type' => 'presentation',
            ]
        ];

        // Insert data using Eloquent
        foreach ($criteria as $item) {
            ProposalCriteria::create($item);
        }
    }
}
