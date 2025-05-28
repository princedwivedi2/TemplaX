<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'preview_image',
        'view_path',
        'is_active',
        'sort_order',
        'color_scheme',
        'category',
        'created_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'color_scheme' => 'array'
    ];

    /**
     * Get the user who created this template.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all business cards using this template.
     */
    public function businessCards()
    {
        return $this->hasMany(BusinessCard::class, 'template', 'slug');
    }

    /**
     * Scope to get only active templates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get the preview image URL.
     */
    public function getPreviewImageUrlAttribute()
    {
        return $this->preview_image ? asset('storage/' . $this->preview_image) : asset('images/template-placeholder.png');
    }

    /**
     * Get the template view path for rendering.
     */
    public function getViewPathAttribute($value)
    {
        return $value ?: "cards.templates.{$this->slug}";
    }

    /**
     * Get available templates as array for dropdowns.
     */
    public static function getAvailableTemplates()
    {
        return self::active()->ordered()->get()->pluck('name', 'slug')->toArray();
    }

    /**
     * Get template configuration for frontend.
     */
    public function getConfigAttribute()
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'preview_image' => $this->preview_image_url,
            'color_scheme' => $this->color_scheme,
            'category' => $this->category
        ];
    }

    /**
     * Check if template is being used by any business cards.
     */
    public function isInUse()
    {
        return $this->businessCards()->exists();
    }

    /**
     * Get usage count.
     */
    public function getUsageCountAttribute()
    {
        return $this->businessCards()->count();
    }
}
