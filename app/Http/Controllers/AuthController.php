<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|min:8',
        ]);
        $user = User::create($validated);
    }

    function authorize(Request $request) {
       
        $validated = $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return "Пользователь не найден";
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return "Пароли не совпадают!";
        }
        session(['user_id' => $user->id]);
        return redirect('/me');
    }
}