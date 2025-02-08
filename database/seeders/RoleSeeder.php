<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat role
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Warung']);

        // Membuat akun admin
        $admin = User::create([
            'id' => 1,
            'name' => 'Bagas Aldianata',
            'email' => 'admin@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('12345678'),
            'photo_profile' => null,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $admin = User::find(1); // Ganti dengan ID admin
        // Assign role ke admin
        $admin->assignRole('Admin');
    }
}
