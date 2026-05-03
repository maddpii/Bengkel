<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Password teks biasa; cast 'hashed' di model User meng-hash ke bcrypt saat disimpan.
        User::query()->updateOrCreate(
            ['email' => 'admin@bengkel.test'],
            [
                'name' => 'Administrator',
                'password' => 'password',
                'role' => 'admin',
                'phone' => null,
                'address' => null,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'admin123@gmail.com'],
            [
                'name' => 'Admin Utama',
                'password' => 'admin1234',
                'role' => 'admin',
                'phone' => null,
                'address' => null,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'customer@bengkel.test'],
            [
                'name' => 'Pelanggan Demo',
                'password' => 'password',
                'role' => 'customer',
                'phone' => null,
                'address' => null,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'mekanik@bengkel.test'],
            [
                'name' => 'Mekanik Demo',
                'password' => 'password',
                'role' => 'mekanik',
                'phone' => null,
                'address' => null,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'kasir@bengkel.test'],
            [
                'name' => 'Kasir Demo',
                'password' => 'password',
                'role' => 'kasir',
                'phone' => null,
                'address' => null,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'owner@bengkel.test'],
            [
                'name' => 'Owner Demo',
                'password' => 'password',
                'role' => 'owner',
                'phone' => null,
                'address' => null,
            ]
        );

        SiteContent::current();
    }
}
