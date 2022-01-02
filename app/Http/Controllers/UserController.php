<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\CurrentPassword;
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

        return redirect()->back()->with('success', 'Profile berhasil disimpan');
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
                'password' =>'required|confirmed|min:6'
            ]
        );

        $user = User::where('activation_token', $token)->firstOrFail();

        if($user){
            $opening_status = User::STATUS_ACTIVATED;
            if($user->hasRole(config('enums.roles.student')) && $user->kelas_id == null){
                $opening_status = User::STATUS_SUSPENDED;
            }

            $user->update(
                [
                    'password' => Hash::make($request->password),
                    'activation_expired_at' => null,
                    'activation_token' => null,
                    'opening_status' => $opening_status
                ]
            );
        }

        return redirect()->route('activation.success');
    }

    public function success()
    {
        return view('pages.user.activation_success');
    }

    public function updatePassword(Request $request)
    {
        $request->validate(
            [
                'current_password' =>['required', new CurrentPassword()],
                'new_password' =>'required|confirmed|min:6'
            ]
        );

        $user = User::findOrFail(auth()->id());

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'Password berhasil disimpan');
    }
}
