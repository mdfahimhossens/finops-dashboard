<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Roles ensure
        $admin   = Role::firstOrCreate(['role_name' => 'admin']);
        $manager = Role::firstOrCreate(['role_name' => 'manager']);
        $viewer  = Role::firstOrCreate(['role_name' => 'viewer']);

        // Main admin ensure (match by email)
        User::firstOrCreate(
            ['email' => 'mdfahimhossen629@gmail.com'],   // <-- where clause
            [
                'name'     => 'Fahim',
                'username' => 'Main Admin',
                'password' => Hash::make('Admin@123456'),
                'slug' => Str::slug('main-admin'),
                'role_id'  => $admin->id,
            ]
        );
    }
}
