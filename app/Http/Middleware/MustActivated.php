<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MustActivated
{
    public function handle(Request $request, Closure $next)
    {
        $opening_status = auth()->user()->opening_status;
        if ($opening_status != User::STATUS_ACTIVATED && !$request->expectsJson()) {
            Auth::logout();
            $message = $opening_status == User::STATUS_REGISTERED ? 'User is not activated' : 'User has been suspended';
            return redirect()->route('login')->with('validate', $message);
        }

        switch (auth()->user()->opening_status) {
            case User::STATUS_REGISTERED:
                Auth::logout();
                return ApiResponse::error('User must be activated', 401);
            case User::STATUS_ACTIVATED:
                return $next($request);
            case User::STATUS_SUSPENDED:
                Auth::logout();
                return ApiResponse::error('User has been suspended', 401);
                break;
            default:
                Auth::logout();
                return ApiResponse::error('User must be activated', 401);
                break;
        }
    }
}
