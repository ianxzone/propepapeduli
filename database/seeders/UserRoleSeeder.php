<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin ProPePa',
                'email' => 'superadmin@propepa.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Administrator',
                'email' => 'admin@propepa.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Dosen Pembimbing',
                'email' => 'dosen@propepa.id',
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
