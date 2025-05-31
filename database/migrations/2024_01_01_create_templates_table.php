<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('preview_image')->nullable();
            $table->string('view_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('color_scheme')->nullable();
            $table->string('category')->default('general');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Insert default templates
        DB::table('templates')->insert([
            [
                'name' => 'Modern',
                'slug' => 'modern',
                'description' => 'A modern design with gradient background and clean layout',
                'view_path' => 'cards.templates.modern',
                'is_active' => true,
                'sort_order' => 1,
                'category' => 'professional',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Minimal',
                'slug' => 'minimal',
                'description' => 'A minimalist design with clean typography and subtle details',
                'view_path' => 'cards.templates.minimal',
                'is_active' => true,
                'sort_order' => 2,
                'category' => 'professional',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Creative',
                'slug' => 'creative',
                'description' => 'A creative design with bold colors and unique layout',
                'view_path' => 'cards.templates.creative',
                'is_active' => true,
                'sort_order' => 3,
                'category' => 'creative',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Corporate',
                'slug' => 'corporate',
                'description' => 'A professional corporate design with classic layout',
                'view_path' => 'cards.templates.corporate',
                'is_active' => true,
                'sort_order' => 4,
                'category' => 'professional',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('templates');
    }
} 