<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KBK;
use App\Models\SubKBK;

class KBKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $kbkData = [
            [
                'name' => 'Business Intelligence',
                'description' => 'Bidang keahlian yang berkaitan dengan analisis data untuk mendukung pengambilan keputusan bisnis.',
                'subkbks' => [
                    [
                        'name' => 'Data Mining',
                        'description' => 'Teknik ekstraksi informasi dari data besar untuk menemukan pola dan hubungan.'
                    ],
                    [
                        'name' => 'Data Warehousing',
                        'description' => 'Pengelolaan data dalam jumlah besar untuk keperluan analisis dan reporting.'
                    ],
                    [
                        'name' => 'Predictive Analytics',
                        'description' => 'Penggunaan model statistik dan machine learning untuk memprediksi hasil bisnis.'
                    ],
                    [
                        'name' => 'Decision Support Systems',
                        'description' => 'Sistem yang mendukung pengambilan keputusan melalui data dan model.'
                    ],
                    [
                        'name' => 'Data Visualization',
                        'description' => 'Penyajian data dalam bentuk visual untuk memudahkan pemahaman informasi.'
                    ]
                ]
            ],
            [
                'name' => 'Information Systems Engineering',
                'description' => 'Bidang keahlian yang berfokus pada pengembangan dan implementasi sistem informasi.',
                'subkbks' => [
                    [
                        'name' => 'System Analysis and Design',
                        'description' => 'Analisis kebutuhan dan desain sistem untuk memenuhi kebutuhan bisnis.'
                    ],
                    [
                        'name' => 'Enterprise Architecture',
                        'description' => 'Kerangka kerja untuk mengelola dan mengintegrasikan sumber daya teknologi informasi dalam perusahaan.'
                    ],
                    [
                        'name' => 'Software Engineering',
                        'description' => 'Proses perancangan, pengembangan, dan pemeliharaan perangkat lunak.'
                    ],
                    [
                        'name' => 'Requirements Engineering',
                        'description' => 'Proses identifikasi dan dokumentasi kebutuhan pengguna untuk sistem yang akan dikembangkan.'
                    ],
                    [
                        'name' => 'Human-Computer Interaction',
                        'description' => 'Studi tentang bagaimana manusia berinteraksi dengan komputer dan antarmuka pengguna.'
                    ]
                ]
            ]
        ];

        // Loop untuk menyimpan data KBK dan SubKBK
        foreach ($kbkData as $kbkItem) {
            // Membuat KBK
            $kbk = KBK::create([
                'name' => $kbkItem['name'],
                'description' => $kbkItem['description']
            ]);

            // Membuat SubKBK terkait untuk KBK yang baru dibuat
            foreach ($kbkItem['subkbks'] as $subkbkItem) {
                SubKBK::create([
                    'kbk_id' => $kbk->id,
                    'name' => $subkbkItem['name'],
                    'description' => $subkbkItem['description']
                ]);
            }
        }
    }
}
