<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;

class PaymentController extends Controller
{
    public function return(): View
    {
        return view('payment.return');
    }
}
