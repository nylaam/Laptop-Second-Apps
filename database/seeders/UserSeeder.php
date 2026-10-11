<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['Admin LaptopSecond', 'admin@laptopsecond.test', UserRole::Admin],
            ['Farrasha Customer', 'customer@laptopsecond.test', UserRole::Pembeli],
        ];

        foreach ($accounts as [$name, $email, $role]) {
            User::updateOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => Hash::make('password'), 'role' => $role],
            );
        }
    }
}
