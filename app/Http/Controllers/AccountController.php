<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AccountController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login(Request $request, AuthService $authService)
    {
        $request->validate([
            'email'    => 'required|email|exists:users',
            'password' => 'required'
        ]);

        ['token' => $token, 'name' => $name] = $authService->login($request->toArray());

        return ['token' => $token->plainTextToken, 'name' => $name];
    }
}
