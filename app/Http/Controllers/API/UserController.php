<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function info()
    {
        $user_id = auth()->id();

        $user = User::with('class')->findOrFail($user_id);

        return ApiResponse::success($user);
    }
}
