<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Template extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

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
        return Cache::remember('available_templates', 3600, function () {
            return static::where('is_active', true)
                ->select(['id', 'name', 'slug', 'description', 'preview_image_url'])
                ->get();
        });
    }

    /**
     * Get template with cached relations
     */
    public static function getTemplateWithConfig($slug)
    {
        return Cache::remember('template_' . $slug, 3600, function () use ($slug) {
            return static::where('slug', $slug)
                ->where('is_active', true)
                ->first();
        });
    }

    /**
     * Clear template cache
     */
    public static function clearCache($slug = null)
    {
        if ($slug) {
            Cache::forget('template_' . $slug);
        } else {
            Cache::forget('available_templates');
        }
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
