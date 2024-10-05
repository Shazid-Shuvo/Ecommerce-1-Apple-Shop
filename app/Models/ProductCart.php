<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCart extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id','product_id','color','qty','size','price'
    ];

    public function product(): BelongsTo{
        return $this->BelongsTo(Product::class);
    }
}
