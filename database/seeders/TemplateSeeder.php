<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Modern',
                'slug' => 'modern',
                'description' => 'A sleek modern design with black and red color scheme, perfect for creative professionals.',
                'preview_image' => null,
                'view_path' => 'cards.templates.modern',
                'is_active' => true,
                'sort_order' => 1,
                'color_scheme' => [
                    'primary' => '#000000',
                    'secondary' => '#c0392b',
                    'accent' => '#d3b9b9'
                ],
                'category' => 'business'
            ],
            [
                'name' => 'Classic',
                'slug' => 'classic',
                'description' => 'A timeless classic design with professional blue tones, ideal for corporate environments.',
                'preview_image' => null,
                'view_path' => 'cards.templates.classic',
                'is_active' => true,
                'sort_order' => 2,
                'color_scheme' => [
                    'primary' => '#1e3a8a',
                    'secondary' => '#3b82f6',
                    'accent' => '#dbeafe'
                ],
                'category' => 'business'
            ],
            [
                'name' => 'Minimal',
                'slug' => 'minimal',
                'description' => 'A clean minimal design with warm yellow accents, great for personal branding.',
                'preview_image' => null,
                'view_path' => 'cards.templates.minimal',
                'is_active' => true,
                'sort_order' => 3,
                'color_scheme' => [
                    'primary' => '#fbbf24',
                    'secondary' => '#f59e0b',
                    'accent' => '#fef3c7'
                ],
                'category' => 'personal'
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
