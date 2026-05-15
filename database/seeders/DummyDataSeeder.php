<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Module;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create School
        $school = School::create([
            'name' => 'SD Negeri 1 Merdeka',
            'address' => 'Jl. Pendidikan No. 45, Jakarta Pusat',
            'city' => 'Jakarta'
        ]);

        // 2. Create Classes
        $class5A = SchoolClass::create([
            'school_id' => $school->id,
            'name' => 'Kelas 5A',
            'class_code' => '5A-2024',
            'teacher_name' => 'Bpk. Budi Santoso, M.Pd'
        ]);

        $class5B = SchoolClass::create([
            'school_id' => $school->id,
            'name' => 'Kelas 5B',
            'class_code' => '5B-2024',
            'teacher_name' => 'Ibu Siti Aminah, S.Pd'
        ]);

        // 3. Create Teachers (as Users)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'guru@propepa.id',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'class_id' => $class5A->id
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@propepa.id',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'class_id' => $class5B->id
        ]);

        // 4. Create Students
        $studentsA = ['Ahmad', 'Bambang', 'Cici', 'Dedi', 'Euis', 'Farhan', 'Gita', 'Hadi', 'Indah', 'Joko'];
        foreach ($studentsA as $name) {
            User::create([
                'name' => $name . ' (5A)',
                'email' => strtolower($name) . '@siswa.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'class_id' => $class5A->id,
                'points' => rand(100, 2000)
            ]);
        }

        $studentsB = ['Kurnia', 'Laras', 'Maman', 'Nana', 'Oki', 'Putri', 'Qori', 'Raka', 'Siska', 'Tono'];
        foreach ($studentsB as $name) {
            User::create([
                'name' => $name . ' (5B)',
                'email' => strtolower($name) . '@siswa.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'class_id' => $class5B->id,
                'points' => rand(100, 2000)
            ]);
        }

        // 5. Create Modules
        $modules = [
            [
                'title' => 'Pencemaran Sungai',
                'description' => 'Mempelajari dampak sampah plastik terhadap ekosistem sungai di sekitar kita.',
                'thumbnail' => 'https://cdn.pixabay.com/photo/2017/10/10/00/03/trash-2835431_1280.jpg',
                'order' => 1,
                'content' => [
                    'P' => [
                        'title' => 'Peka terhadap Masalah',
                        'description' => 'Lihatlah sekelilingmu, apakah sungai di dekatmu bersih?',
                        'video_url' => 'https://www.youtube.com/embed/D3vV84wG2k0'
                    ],
                    'E' => [
                        'title' => 'Eksplorasi Isu',
                        'description' => 'Mari kita cari tahu apa saja jenis limbah yang paling banyak mencemari sungai.',
                        'video_url' => 'https://www.youtube.com/embed/9G_9R2p6yio'
                    ],
                    'D' => [
                        'title' => 'Diskusi Solusi',
                        'description' => 'Diskusikan dengan teman kelompokmu, apa yang bisa kita lakukan untuk mengurangi sampah?',
                        'video_url' => ''
                    ],
                    'U' => [
                        'title' => 'Ungkapkan Pendapat',
                        'description' => 'Tuliskan refleksimu di jurnal harian mengenai kondisi sungai kita.',
                        'video_url' => ''
                    ],
                    'L' => [
                        'title' => 'Lakukan Aksi',
                        'description' => 'Mari kita buat poster kampanye untuk tidak membuang sampah ke sungai.',
                        'video_url' => ''
                    ],
                    'I' => [
                        'title' => 'Introspeksi Diri',
                        'description' => 'Apa yang sudah kamu pelajari hari ini? Apakah kamu sudah berkomitmen menjaga lingkungan?',
                        'video_url' => ''
                    ]
                ]
            ],
            [
                'title' => 'Energi Terbarukan',
                'description' => 'Mengenal pemanfaatan tenaga surya dan angin untuk masa depan Indonesia.',
                'thumbnail' => 'https://cdn.pixabay.com/photo/2016/11/18/16/05/solar-panels-1835529_1280.jpg',
                'order' => 2,
                'content' => [
                    'P' => [
                        'title' => 'Peka terhadap Masalah',
                        'description' => 'Pernahkah kamu berpikir dari mana listrik di rumahmu berasal?',
                        'video_url' => 'https://www.youtube.com/embed/GqtUWyDR1fg'
                    ],
                    'E' => [
                        'title' => 'Eksplorasi Isu',
                        'description' => 'Mari eksplorasi bagaimana panel surya menangkap cahaya matahari.',
                        'video_url' => 'https://www.youtube.com/embed/0elhIdu8Ums'
                    ],
                    'D' => [
                        'title' => 'Diskusi Solusi',
                        'description' => 'Apakah sekolah kita cocok menggunakan energi surya?',
                        'video_url' => ''
                    ],
                    'U' => [
                        'title' => 'Ungkapkan Pendapat',
                        'description' => 'Tuliskan ide kreatifmu tentang alat bertenaga surya.',
                        'video_url' => ''
                    ],
                    'L' => [
                        'title' => 'Lakukan Aksi',
                        'description' => 'Eksperimen sederhana membuat oven tenaga surya.',
                        'video_url' => ''
                    ],
                    'I' => [
                        'title' => 'Introspeksi Diri',
                        'description' => 'Bagaimana kita bisa menghemat energi di rumah?',
                        'video_url' => ''
                    ]
                ]
            ],
            [
                'title' => 'Sampah Plastik & Laut',
                'description' => 'Melihat bahaya mikroplastik bagi kesehatan manusia dan biota laut.',
                'thumbnail' => 'https://cdn.pixabay.com/photo/2019/12/12/15/22/turtle-4690940_1280.jpg',
                'order' => 3,
                'content' => [
                    'P' => [
                        'title' => 'Peka terhadap Masalah',
                        'description' => 'Sedotan plastik yang kita buang bisa membahayakan kura-kura di laut.',
                        'video_url' => 'https://www.youtube.com/embed/ju_2nuK5O-E'
                    ],
                    'E' => [
                        'title' => 'Eksplorasi Isu',
                        'description' => 'Bagaimana plastik hancur menjadi mikroplastik?',
                        'video_url' => 'https://www.youtube.com/embed/RS7IzU2VJIQ'
                    ],
                    'D' => [
                        'title' => 'Diskusi Solusi',
                        'description' => 'Apa pengganti plastik yang ramah lingkungan?',
                        'video_url' => ''
                    ],
                    'U' => [
                        'title' => 'Ungkapkan Pendapat',
                        'description' => 'Refleksi tentang bahaya mikroplastik dalam rantai makanan.',
                        'video_url' => ''
                    ],
                    'L' => [
                        'title' => 'Lakukan Aksi',
                        'description' => 'Kampanye pengurangan penggunaan plastik sekali pakai.',
                        'video_url' => ''
                    ],
                    'I' => [
                        'title' => 'Introspeksi Diri',
                        'description' => 'Mulai hari ini, saya tidak akan menggunakan kantong plastik.',
                        'video_url' => ''
                    ]
                ]
            ]
        ];

        foreach ($modules as $mod) {
            Module::create($mod);
        }
    }
}
