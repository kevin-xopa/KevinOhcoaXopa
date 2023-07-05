<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use App\Helper\DataResponse;
use Illuminate\Http\Request;
use App\Models\ProductTranslation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductPut;
use App\Http\Requests\Products\StoreProductPost;
use App\Http\Requests\Products\StoreProductDelete;

class ProductsController extends Controller
{
    use DataResponse;

    public function products(Request $request)
    {
        $products = Product::join('product_translations', 'product_translations.product_id', 'products.id');
        $products = $request->only_trashed == "true" ? $products->onlyTrashed() : $products;
        $products = $products->select(
            'products.*',
            'product_translations.*'
        );

        $products = $request->sku != null ? $products->where('products.sku', $request->sku) : $products;
        $products = $request->points != null ? $products->where('products.points', $request->points) : $products;
        $products = $request->dollar_price != null ? $products->whereBetween('products.dollar_price', $request->dollar_price) : $products;
        $products = $request->price_pesos != null ? $products->whereBetween('products.price_pesos', $request->price_pesos) : $products;
        $products = $request->created_at != null ? $products->whereDate('products.created_at', $request->created_at) : $products;
        $products = $request->name != null ? $products->where('product_translations.name', $request->name) : $products;
        $products = $request->description != null ? $products->where('product_translations.description', $request->description) : $products;
        $products = $request->url != null ? $products->where('product_translations.url', $request->url) : $products;
        $products = $request->needle != null ? $products->whereDate('products.created_at', "$request->date")
            ->orWhere('products.sku', "$request->needle")
            ->orWhere('products.points', "$request->needle")
            ->orWhere('product_translations.name', 'like', "%$request->needle%")
            ->orWhere('product_translations.description', 'like', "%$request->needle%")
            ->orWhere('product_translations.long_description', 'like', "%$request->needle%")
            ->orWhere('product_translations.url', 'like', "%$request->needle%") : $products;

        $products =  $products->where('product_translations.language', "es");

        if ($request->recently != false) {
            $products = $products->orderBy('product_translations.name', 'ASC');
        } else {
            $products = $request->order_by != null ? $products->orderBy('product_translations.name', $request->order_by) : $products->orderBy('product_translations.name', 'ASC');
        }

        $products = $request->items_for_paginate != null ? $products->paginate($request->items_for_paginate) : $products->get();

        if ($request->any_data == true) {
            return $products;
        }
        return $this->data_response('Success!', 200, $products);
    }

    public function create(StoreProductPost $request)
    {
        $data = $request->validated();
        $product = Product::create($data);

        $data["product_id"] = $product->id;
        ProductTranslation::create($data);

        $obj_request = new Request();
        $obj_request->query->add(['url' => $request->url]);
        $obj_request->query->add(['any_data' => true]);

        $product = $this->products($obj_request, true);
        return $this->data_response('Successfully registered product', 201, $product);
    }

    public function update(StoreProductPut $request)
    {
        $data = $request->validated();
        $product_up = $request->validated();
        unset($product_up['name']);
        unset($product_up['description']);
        unset($product_up['long_description']);
        unset($product_up['url']);
        unset($product_up['language']);
        unset($product_up['id_product_translations']);
        Product::where('id', $request->id)->update($product_up);

        $data["id"] = $data["id_product_translations"];
        unset($data['sku']);
        unset($data['dollar_price']);
        unset($data['price_pesos']);
        unset($data['points']);
        unset($data['active']);
        unset($data['id_product_translations']);

        ProductTranslation::where('url', $request->old_url)->update($data);

        $obj_request = new Request();
        $obj_request->query->add(['url' => $request->url]);
        $obj_request->query->add(['any_data' => true]);

        $phone_recharge = $this->products($obj_request, true);
        return $this->data_response('Product updated successfully', 200, $phone_recharge);
    }

    public function delete(StoreProductDelete $request)
    {
        Product::where('id', $request->id)->delete();
        return $this->data_response('Product removed successfully, you can recover it in the trash', 200);
    }

    public function permanent_delete(StoreProductDelete $request)
    {
        Product::where('id', $request->id)->forceDelete();
        return $this->data_response('Product successfully permanently removed', 200);
    }

    public function restore(StoreProductDelete $request)
    {
        Product::where('id', $request->id)->restore();
        return $this->data_response('Product successfully restored', 200);
    }
}
