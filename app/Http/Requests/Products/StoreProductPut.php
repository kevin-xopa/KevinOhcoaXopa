<?php

namespace App\Http\Requests\Products;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Helpers\ConversionPesoToDollarController;
use App\Models\ProductTranslation;
use Illuminate\Validation\Rule;

class StoreProductPut extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $product = Product::select('*')->where('sku', $this->sku)->first();
        $product_translations = ProductTranslation::select('*')->where('url', $this->old_url)->first();
        $obj = new ConversionPesoToDollarController();
        $this->merge([
            'id' => isset($product) ? $product->id : null,
            'id_product_translations' => isset($product_translations) ? $product_translations->id : null,
            'dollar_price' => $obj->convertToDollars($this->price_pesos),
            'url' => Str::slug("$product->sku $this->name es", "-"),
            'active' => $this->active == "Activate" ? true : false,
            'language' => "es"
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'exists:products,id',
            'dollar_price' => 'required',
            'price_pesos' => 'required',
            'points' => 'required',
            'active' => 'required',

            'id_product_translations' => 'exists:product_translations,id',
            "name" => 'required',
            "description" => 'required',
            "long_description" => 'required',
            'url' =>  [
                'required',
                Rule::unique('product_translations')->ignore($this->id_product_translations)
            ],
            "language" => 'required',
        ];
    }
}
