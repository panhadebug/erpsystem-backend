<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function login(
        LoginRequest $request
    ) {
        $token = $this
            ->authService
            ->login(
                $request->validated()
            );

        return response()->json([
            'token' => $token
        ]);
    }
}

