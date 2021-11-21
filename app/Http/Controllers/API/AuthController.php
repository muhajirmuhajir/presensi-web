<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:8',
            ]);

            $user = User::where('email', $request->email)->firstOrFail();

            if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }

            $token = $user->createToken('mobile_token')->plainTextToken;

            return ApiResponse::success(['token' => $token]);

        } catch (Exception $e) {

            return ApiResponse::error($e->getMessage());

        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::success('token revoked');
    }

}
