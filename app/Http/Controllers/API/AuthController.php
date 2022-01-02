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
                throw new Exception("email or password is incorrect");
            }

            if($user->opening_status == User::STATUS_REGISTERED){
                throw new Exception("User must be activated");
            }else if($user->opening_status == User::STATUS_SUSPENDED){
                throw new Exception("User has been suspended");
            }

            if(!$user->hasRole(config('enums.roles.student'))){
                throw new Exception("User is not authorized");
            }

            $token = $user->createToken('mobile_token')->plainTextToken;

            return ApiResponse::success(['token' => $token]);

        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 403);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::success('token revoked');
    }

}
