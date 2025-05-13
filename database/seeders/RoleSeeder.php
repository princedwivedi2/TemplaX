<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assign roles dynamically if needed
        $roles = ['super-admin', 'admin', 'user'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Assign roles to users (assuming user with ID 1 exists)
        $user = User::find(1);
        if ($user) {
            $user->assignRole('super-admin');
        }
    }
}
