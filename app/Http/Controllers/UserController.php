<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('pages.user.show',compact('user'));
    }

    public function update(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'phone_number' => 'nullable|string'
        ]);
        $user = User::findOrFail(auth()->id());
        $user->update($fields);

        return redirect()->route('dashboard');
    }

    public function activate(Request $request, $token)
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }
        // search user where has same token
        $user = User::where('activation_token', $token)->firstOrFail();

        return view('pages.user.create_password', compact('user','token'));
    }

    public function verifiy(Request $request, $token)
    {
        $request->validate(
            [
                'password' =>'required|confirmed'
            ]
        );

        $user = User::where('activation_token', $token)->firstOrFail();

        if($user){
            $user->update(
                [
                    'password' => Hash::make($request->password),
                    'activation_expired_at' => null,
                    'activation_token' => null,
                    'opening_status' => User::STATUS_ACTIVATED
                ]
            );
        }

        return redirect()->route('activation.success');
    }

    public function success()
    {
        return view('pages.user.activation_success');
    }
}
