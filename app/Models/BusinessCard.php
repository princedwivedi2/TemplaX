<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessCard extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'job_title',
        'company_name',
        'email',
        'phone',
        'website',
        'address',
        'linkedin',
        'twitter',
        'logo_path',
        'template',
        'background_image',
        'instagram',
        'facebook',
        'whatsapp',
        'navigate'
    ];

    /**
     * Get the user that owns the business card.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the template used by this business card.
     */
    public function templateModel()
    {
        return $this->belongsTo(Template::class, 'template', 'slug');
    }

    /**
     * Get the card's logo URL.
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : null;
    }

    /**
     * Scope to get all cards for a specific user or all cards for super admin
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include cards with a specific template.
     */
    public function scopeWithTemplate($query, $template)
    {
        return $query->where('template', $template);
    }

    /**
     * Get a human-readable created date
     */
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('M d, Y');
    }

    /**
     * Get the status badge HTML
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'draft' => 'bg-secondary',
            'active' => 'bg-success',
            'archived' => 'bg-danger'
        ];

        return sprintf(
            '<span class="badge %s">%s</span>',
            $colors[$this->status] ?? 'bg-secondary',
            ucfirst($this->status)
        );
    }

    /**
     * Get the template-specific data
     */
    public function getTemplateData()
    {
        $data = $this->toArray();
        
        // Add template-specific data
        switch ($this->template) {
            case 'elegant':
                $data['social_links'] = [
                    'instagram' => $this->instagram,
                    'facebook' => $this->facebook,
                    'whatsapp' => $this->whatsapp,
                    'navigate' => $this->navigate,
                ];
                break;
        }

        return $data;
    }
}
