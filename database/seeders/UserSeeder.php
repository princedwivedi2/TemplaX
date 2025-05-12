<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create super admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'organization' => 'TemplaX',
            'password' => Hash::make('password123'),
        ]);

        // Assign super-admin role
        $superAdmin->assignRole('super-admin');
    }
}
