<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar permissions
        $permissions = [
            'edit warung',
            'hapus warung',
            'lihat menu',
            'tambah menu',
            'edit menu',
            'hapus menu',
            'tambah ulasan',
            'lihat ulasan',
    ];

        // Membuat permissions jika belum ada
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permission ke role Admin
        $adminRole = Role::findByName('Admin');
        $adminRole->givePermissionTo(Permission::all());

        // Assign permission tertentu ke role Warung
        $warungRole = Role::findByName('Warung');
        $warungRole->givePermissionTo([
            'edit warung',
            'hapus warung',
            'lihat menu',
            'tambah menu',
            'edit menu',
            'hapus menu',
            'lihat ulasan',
        ]);

        // Assign permission tertentu ke role User
        $userRole = Role::findByName('User');
        $userRole->givePermissionTo([
            'lihat menu',
            'tambah ulasan',
            'lihat ulasan',
        ]);
    }
}
