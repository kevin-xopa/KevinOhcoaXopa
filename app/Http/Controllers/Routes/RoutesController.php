<?php

namespace App\Http\Controllers\Routes;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoutesController extends Controller
{

    #Redirection to Dashboard
    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }


    #Redirection to Product
    public function product()
    {
        return Inertia::render('Products/Product');
    }

    #Redirection to Products
    public function products()
    {
        return Inertia::render('Products/Products');
    }

    #Redirection to restore Products
    public function productos_dump()
    {
        return Inertia::render('Products/ProductsDump');
    }
}
