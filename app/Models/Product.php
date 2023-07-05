<?php

namespace App\Models;

use App\Models\ProductTranslation;
use Database\Factories\ProductsFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ProductsFactory::new();
    }

    public function product_translations()
    {
        return $this->belongsTo(ProductTranslation::class);
    }

    public function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => date('d M, Y, h:i a', strtotime($value)),
            // set: fn ($value) => Crypt::encryptString(Storage::url('documents/' . $value)),
        );
    }

    public function updatedAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => date('d M, Y, h:i a', strtotime($value)),
            // set: fn ($value) => Crypt::encryptString(Storage::url('documents/' . $value)),
        );
    }

    public function deletedAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value != null ? date('d M, Y, h:i a', strtotime($value)) : null,
            // set: fn ($value) => Crypt::encryptString(Storage::url('documents/' . $value)),
        );
    }
}
