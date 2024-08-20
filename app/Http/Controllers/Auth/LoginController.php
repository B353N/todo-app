<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws ValidationException
     */
    public function __invoke(LoginRequest $request)
    {
        // Try to log in user
        if (!auth()->attempt($request->only('email', 'password'))) {
            return $this->responseWithError('Invalid credentials', 'invalid_credentials');
        }

        return response()->json([
            'token' => auth()->user()->createToken('auth_token')->plainTextToken
        ]);
    }
}
