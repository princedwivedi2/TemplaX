<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            [
                'name' => 'Minimal',
                'slug' => 'minimal',
                'description' => 'A clean and minimal business card design',
                'is_active' => true,
                'sort_order' => 1,
                'category' => 'standard'
            ],
            [
                'name' => 'Modern',
                'slug' => 'modern',
                'description' => 'A modern and sleek business card design',
                'is_active' => true,
                'sort_order' => 2,
                'category' => 'standard'
            ],
            [
                'name' => 'Classic',
                'slug' => 'classic',
                'description' => 'A classic and professional business card design',
                'is_active' => true,
                'sort_order' => 3,
                'category' => 'standard'
            ],
            [
                'name' => 'Landscape',
                'slug' => 'landscape',
                'description' => 'A wide and modern landscape business card design',
                'is_active' => true,
                'sort_order' => 4,
                'category' => 'landscape'
            ],
            [
                'name' => 'Portrait',
                'slug' => 'portrait',
                'description' => 'A tall and elegant portrait business card design',
                'is_active' => true,
                'sort_order' => 5,
                'category' => 'portrait'
            ]
        ];

        foreach ($templates as $template) {
            Template::updateOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }
    }
} 