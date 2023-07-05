<?php

namespace App\Models;

use App\Models\ProductTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "sku",
        "dollar_price",
        "price_pesos",
        "points",
        "active",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    public function product_translations()
    {
        return $this->belongsTo(ProductTranslation::class);
    }
}
