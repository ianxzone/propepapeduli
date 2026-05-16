<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use Illuminate\Support\Str;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content = [
            'P' => [
                'title' => 'Krisis Sampah Plastik Kota Cimahi & Kisah Pak Ade',
                'video_url' => 'https://www.youtube.com/embed/dummy-kali-cimahi',
                'description' => 'Kota Cimahi menghasilkan 580 ton sampah per hari (14% plastik). Simak kisah nyata Pak Ade (52 tahun), nelayan Kali Cimahi yang jaringnya dipenuhi sampah plastik sehingga hasil tangkapan turun dari 15 kg menjadi 2 kg. Dampaknya, anak bungsunya, Sari (10 tahun), terpaksa berhenti les.',
                'task_instruction' => 'Tuliskan 2-3 fakta baru atau hal yang paling mengejutkan bagi kamu dari kisah Pak Ade.',
            ],
            'E' => [
                'title' => 'Kacamata Perspektif',
                'stakeholders' => [
                    [
                        'role' => 'Masyarakat / Nelayan (Pak Ade)',
                        'focus' => 'Penurunan pendapatan ekonomi dan pendidikan anak akibat jaring penuh plastik.'
                    ],
                    [
                        'role' => 'Pemerintah Kota (Dinas Lingkungan Hidup)',
                        'focus' => 'Beban operasional pengelolaan 580 ton sampah/hari dan keterbatasan lahan TPA.'
                    ],
                    [
                        'role' => 'Pengusaha Industri Plastik/Kemasan',
                        'focus' => 'Efisiensi biaya produksi, penyerapan tenaga kerja pabrik, dan kebutuhan konsumen.'
                    ],
                    [
                        'role' => 'Generasi Muda / Aktivis Lingkungan',
                        'focus' => 'Kerusakan jangka panjang ekologi sungai, mikroplastik, dan masa depan bumi.'
                    ],
                ],
            ],
            'D' => [
                'title' => 'Skenario Keputusan / Rapat Warga',
                'type' => 'chat', // Default to chat as requested in logic
                'dilemma_story' => 'Dalam rapat warga Kali Cimahi, muncul pertentangan mengenai solusi terbaik untuk mengatasi krisis sampah plastik ini.',
                'options' => [
                    'Usulan A' => 'Industri manufaktur wajib membayar biaya pembersihan sungai dan ganti rugi total kepada nelayan lokal.',
                    'Usulan B' => 'Sistem pendanaan gotong royong untuk membuat TPS Terpadu (Industri 60%, Pemerintah 30%, Masyarakat/Siswa 10%).',
                    'Usulan C' => 'Pelarangan plastik sekali pakai secara total di seluruh lingkungan sekolah se-Kota Cimahi dan wajib edukasi zero waste.',
                ],
            ],
            'U' => [
                'title' => 'Jurnal Empati',
                'prompt_question' => 'Bagaimana perasaanmu setelah menempatkan diri pada kacamata perspektif Pak Ade dan Sari? Ungkapkan secara jujur.',
                'features_enabled' => ['text_editor', 'emoji_picker_10_options', 'voice_note_recorder'],
            ],
            'L' => [
                'title' => 'Menu Aksi Sosial SMART',
                'options' => [
                    [
                        'type' => 'Aksi Individu',
                        'description' => 'Komitmen 7 hari bebas kantong plastik sekali pakai dengan membawa tumbler dan kotak makan sendiri ke sekolah.'
                    ],
                    [
                        'type' => 'Aksi Kelompok',
                        'description' => 'Membuat 2 poster kampanye lingkungan kreatif atau melakukan audit jenis sampah di area sekolah selama 3 hari.'
                    ],
                    [
                        'type' => 'Aksi Kelas/Lanjutan',
                        'description' => 'Mengorganisasi "Hari Bebas Plastik Sekolah" atau menulis surat saran bersama kepada Lurah/Dinas Lingkungan Hidup.'
                    ],
                ],
                'submission_requirements' => ['photo_upload', 'mini_report_text'],
            ],
            'I' => [
                'title' => 'Introspeksi',
                'reflection_prompt' => 'Apa yang berubah dalam dirimu setelah menyelesaikan aksi nyata ini? Kebiasaan baik apa yang berkomitmen kamu jaga untuk bumi?',
            ],
            'S' => [
                'title' => 'Selesai',
                'summary' => 'Selamat! Kamu telah menyelesaikan petualangan empati di Modul 1. Teruslah menjadi pahlawan lingkungan bagi sekitarmu.',
            ]
        ];

        Module::updateOrCreate(
            ['slug' => 'lingkungan-sehat-sampah-bukan-takdir'],
            [
                'title' => 'Sampah Bukan Takdir: Siapa Bertanggung Jawab?',
                'description' => 'Modul 1: Investigasi krisis sampah plastik dan dampaknya terhadap masyarakat pesisir.',
                'is_active' => true,
                'content' => $content,
                'thumbnail' => 'https://cdn.pixabay.com/photo/2017/04/05/01/16/ocean-2203720_1280.jpg',
                'badge_name' => 'Pejuang Lingkungan',
                'badge_icon' => 'eco',
            ]
        );
    }
}
