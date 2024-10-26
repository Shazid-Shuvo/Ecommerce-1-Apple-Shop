<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Brand;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    // Define mass-assignable attributes
    protected $fillable = [
        'name', 'title', 'short_des', 'price', 'discount',
        'discount_price', 'stock', 'star', 'remark',
        'image', 'category_id', 'brand_id', 'user_id'
    ];

    // Define relationships
    public function brand(): BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}

