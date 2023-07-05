<?php

namespace App\Http\Requests\Products;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Helpers\ConversionPesoToDollarController;

class StoreProductPost extends FormRequest
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
        $sku = strtotime(date("Y-m-d H:i:s"));
        $obj = new ConversionPesoToDollarController();
        $this->merge([
            'sku' => strtotime(date("Y-m-d H:i:s")),
            'dollar_price' => $obj->convertToDollars($this->price_pesos),
            'url' => Str::slug("$sku $this->name es", "-"),
            'active' => $this->active == "activate" ? true : false,
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
            'sku' => 'required|unique:products',
            'dollar_price' => 'required',
            'price_pesos' => 'required',
            'points' => 'required',
            'active' => 'required',

            "name" => 'required',
            "description" => 'required',
            "long_description" => 'required',
            "url" => 'required|unique:product_translations',
            "language" => 'required',
        ];
    }
}
