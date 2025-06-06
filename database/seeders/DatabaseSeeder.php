<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,  // This will create the roles first
            UserSeeder::class,  // This will create the super admin user
            TemplateSeeder::class,  // This will create the default templates
        ]);
    }
}
