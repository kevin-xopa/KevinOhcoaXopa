<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ProductTraslationsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "long_description",
        "url",
        "language",
        "product_id",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ProductTraslationsFactory::new();
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
