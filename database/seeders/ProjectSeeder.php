<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. School
        $school = \App\Models\School::create([
            'name' => 'SD Negeri 1 Merdeka',
            'address' => 'Jl. Pendidikan No. 123',
            'city' => 'Bandung',
        ]);

        // 2. Class
        $class = \App\Models\SchoolClass::create([
            'school_id' => $school->id,
            'name' => 'Kelas 5-A',
            'class_code' => '123456',
            'teacher_name' => 'Ibu Siti Aminah',
        ]);

        // 3. Admin
        \App\Models\User::create([
            'name' => 'Administrator',
            'email' => 'admin@propepa.id',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        // 4. Teacher
        \App\Models\User::create([
            'name' => 'Ibu Siti Aminah',
            'email' => 'siti@propepa.id',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'teacher',
            'class_id' => $class->id,
        ]);

        // 4. Students
        $students = [
            'Budi Darmawan',
            'Anisa Rahma',
            'Eka Putra',
            'Andi Pratama',
        ];

        foreach ($students as $name) {
            \App\Models\User::create([
                'name' => $name,
                'role' => 'student',
                'class_id' => $class->id,
                'points' => rand(10, 100),
            ]);
        }

        // 5. Module
        \App\Models\Module::create([
            'title' => 'Sungai Bersih',
            'description' => 'Belajar tentang pentingnya menjaga kebersihan sungai untuk ekosistem.',
            'thumbnail' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA9yqfYEBcbNVaJBf6CnY12Ief-6eZDZAS2gOMaG3UzDS9WN9pY7zC2fLoTj2QUSPAISSvzVxlAUoWKgEx2kE824vJdqU9MkjHwHYxOT4clYKHwq-CwPlY1-s6lGn2vcu05_mRtrQSFErf-6ma90o6k-YrQkJhujSeJmfGMaupfaU8iC-4dp5WOCI8QusjjJU61FIX1kbNdxZtMIU2zbysu1yXI4Xq-0zrltzIkwwqYOQG2gMkdLl2DwAZo26-sWHUWQWv01zvCVYmD',
            'badge_name' => 'Pahlawan Sungai',
            'badge_icon' => 'water_drop',
            'is_active' => true,
        ]);
    }
}
