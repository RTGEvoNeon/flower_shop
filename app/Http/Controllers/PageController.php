<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Показать страницу политики конфиденциальности
     */
    public function privacy()
    {
        return view('pages.privacy', [
            'title' => 'Политика конфиденциальности - Mindale'
        ]);
    }

    /**
     * Показать страницу публичной оферты
     */
    public function terms()
    {
        return view('pages.terms', [
            'title' => 'Публичная оферта - Mindale'
        ]);
    }
}
