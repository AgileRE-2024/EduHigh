<?php

namespace Database\Seeders;

use App\Models\ResultCriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResultCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $criteria = [
            [
                'name' => 'Format dan kelengkapan naskah',
                'weight' => 10.00,
                'category' => 'material',
            ],
            [
                'name' => 'Abstrak',
                'weight' => 10.00,
                'category' => 'material',
            ],
            [
                'name' => 'Kedalaman landasan teori/kepustakaan',
                'weight' => 20.00,
                'category' => 'material',
            ],
            [
                'name' => 'Metode penelitian/penulisan',
                'weight' => 20.00,
                'category' => 'material',
            ],
            [
                'name' => 'Analisis hasil dan pembahasan',
                'weight' => 30.00,
                'category' => 'material',
            ],
            [
                'name' => 'Pengambilan kesimpulan dan saran',
                'weight' => 10.00,
                'category' => 'material',
            ],

            [
                'name' => 'Pemakaian bahasa dan pengaturan waktu saat penyajian',
                'weight' => 10.00,
                'category' => 'presentation',
            ],
            [
                'name' => 'Sikap dan penampilan',
                'weight' => 10.00,
                'category' => 'presentation',
            ],
            [
                'name' => 'Penguasaan materi keilmuan dan metode penelitian',
                'weight' => 40.00,
                'category' => 'presentation',
            ],
            [
                'name' => 'Objektivitas dalam cara menanggapi pernyataan mempertahankan pendapat',
                'weight' => 20.00,
                'category' => 'presentation',
            ],
            [
                'name' => 'Wawasan ilmu-ilmu yang terkait (komprehensif)',
                'weight' => 20.00,
                'category' => 'presentation',
            ],
        ];

        foreach ($criteria as $item) {
            ResultCriteria::create($item);
        }
    }
}
