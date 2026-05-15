<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            [
                'title' => 'Bijak Menabung: Masa Depan Gemilang',
                'description' => 'Belajar cara mengelola uang saku dan pentingnya menabung sejak dini dengan cara yang seru.',
                'order' => 1,
                'is_active' => true,
                'content' => [
                    'P' => [
                        'video_url' => 'https://www.youtube.com/watch?v=M99_G-68Kk0',
                        'story_images' => "https://images.unsplash.com/photo-1554224155-1696413565d3?w=800\nhttps://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=800\nhttps://images.unsplash.com/photo-1565514020179-026b92b84bb6?w=800",
                        'text' => '<h2>Mengapa Harus Menabung?</h2><ul><li><strong>Kebutuhan Darurat:</strong> Membantu saat ada keperluan mendesak.</li><li><strong>Impian Masa Depan:</strong> Membeli barang yang diinginkan tanpa merepotkan orang lain.</li><li><strong>Disiplin:</strong> Melatih diri untuk tidak boros.</li></ul><p>Data menunjukkan bahwa 70% anak yang gemar menabung memiliki manajemen keuangan yang lebih baik saat dewasa.</p>',
                        'file_url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
                    ],
                    'E' => ['questions' => []],
                    'D' => ['text' => ''],
                    'U' => ['text' => ''],
                    'L' => ['text' => ''],
                    'I' => ['text' => '']
                ]
            ],
            [
                'title' => 'Sahabat Alam: Melindungi Fauna Lokal',
                'description' => 'Mengenal hewan-hewan unik di sekitar kita dan bagaimana cara menjaga habitat mereka.',
                'order' => 2,
                'is_active' => true,
                'content' => [
                    'P' => [
                        'video_url' => 'https://www.youtube.com/watch?v=3-p6E-R87W8',
                        'story_images' => "https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=800\nhttps://images.unsplash.com/photo-1534188753412-3e26d0d618d6?w=800\nhttps://images.unsplash.com/photo-1516641396056-0ce60a85d49f?w=800",
                        'text' => '<h2>Data Fauna Lokal</h2><p>Kita hidup berdampingan dengan banyak spesies unik. Namun, populasi mereka terus menurun akibat kehilangan habitat.</p><table border="1"><thead><tr><th>Spesies</th><th>Status</th></tr></thead><tbody><tr><td>Burung Pipit</td><td>Banyak</td></tr><tr><td>Kupu-Kupu Raja</td><td>Terancam</td></tr><tr><td>Landak Jawa</td><td>Langka</td></tr></tbody></table>',
                        'file_url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
                    ],
                    'E' => ['questions' => []],
                    'D' => ['text' => ''],
                    'U' => ['text' => ''],
                    'L' => ['text' => ''],
                    'I' => ['text' => '']
                ]
            ],
            [
                'title' => 'Pahlawan Digital: Anti Bullying di Internet',
                'description' => 'Membangun karakter positif di dunia maya dan cara menghadapi perundungan digital.',
                'order' => 3,
                'is_active' => true,
                'content' => [
                    'P' => [
                        'video_url' => 'https://www.youtube.com/watch?v=7X89Wn6z7gM',
                        'story_images' => "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800\nhttps://images.unsplash.com/photo-1552664730-d307ca884978?w=800\nhttps://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800",
                        'text' => '<h2>Etika Berkomentar</h2><blockquote>"Pikirkan sebelum mengetik."</blockquote><p>Dunia digital adalah cerminan dunia nyata. Gunakan kata-kata yang mendukung, bukan menjatuhkan.</p><ol><li>Verifikasi informasi sebelum berbagi.</li><li>Gunakan bahasa yang sopan.</li><li>Laporkan perundungan jika melihatnya.</li></ol>',
                        'file_url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
                    ],
                    'E' => ['questions' => []],
                    'D' => ['text' => ''],
                    'U' => ['text' => ''],
                    'L' => ['text' => ''],
                    'I' => ['text' => '']
                ]
            ]
        ];

        foreach ($modules as $data) {
            Module::create($data);
        }
    }
}
