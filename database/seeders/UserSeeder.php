<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    public function run()
    {
        // Create users
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        // Attach roles
        $superAdminRole = DB::table('roles')->where('slug', 'super-admin')->first();
        $adminRole = DB::table('roles')->where('slug', 'admin')->first();
        $userRole = DB::table('roles')->where('slug', 'user')->first();

        DB::table('role_user')->insert([
            ['user_id' => $superAdmin->id, 'role_id' => $superAdminRole->id],
            ['user_id' => $admin->id, 'role_id' => $adminRole->id],
            ['user_id' => $user->id, 'role_id' => $userRole->id],
        ]);
    }
} 