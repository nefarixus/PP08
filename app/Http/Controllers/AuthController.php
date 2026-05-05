<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $login = $data['login'];
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'login';

        if (!Auth::attempt([$field => $login, 'password' => $data['password']], true)) {
            return response()->json([
                'message' => 'Неверный логин или пароль'
            ], 422);
        }

        $request->session()->regenerate();

        $user = $request->user();

        return response()->json([
            'message' => 'OK',
            'user' => [
                'id' => $user->id,
                'login' => $user->login,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string', 'max:255', 'unique:users,login'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::create([
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Registered',
            'user' => [
                'id' => $user->id,
                'login' => $user->login,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ], 201);
    }
}
