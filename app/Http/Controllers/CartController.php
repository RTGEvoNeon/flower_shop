<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class CartController extends Controller
{
    public function cart()
    {
        return view('cart');
    }
}
