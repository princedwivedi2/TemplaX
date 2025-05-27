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
        'card_id',
        'user_id',
        'full_name',
        'job_title',
        'email',
        'phone',
        'company_name',
        'website',
        'address',
        'linkedin',
        'twitter',
        'template',
        'primary_color',
        'accent_color',
        'logo_path',
        'status'
    ];

    /**
     * Get the user that owns the business card.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }    /**
     * Get the card's logo URL.
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : null;
    }
    
    /**
     * Scope to get all cards for a specific user or all cards for super admin
     */
    public function scopeForUser($query, $user)
    {
        if ($user->hasRole('super-admin')) {
            return $query->with('user');
        }
        
        return $query->where('user_id', $user->id);
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
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'card_id';
    }
}
