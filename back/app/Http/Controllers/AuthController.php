<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthRepository $auth
    ) {}

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        return response()->json(
            $this->auth->login($credentials['email'], $credentials['password'])
        );
    }

    public function me(Request $request)
    {
        return response()->json($request->user()->load('profile', 'genres'));
    }

    public function logout(Request $request)
    {
        $this->auth->logout($request->user());

        return response()->noContent();
    }
}
