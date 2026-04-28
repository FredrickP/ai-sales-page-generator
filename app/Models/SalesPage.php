<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesPage extends Model
{
    protected $fillable = [
        'user_id',
        'product_name',
        'description',
        'key_features',
        'target_audience',
        'price',
        'unique_selling_points',
        'headline',
        'subheadline',
        'benefits',
        'features_breakdown',
        'social_proof',
        'cta',
        'full_output',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}