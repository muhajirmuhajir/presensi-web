<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        ]);
        $user = User::findOrFail(auth()->id());
        $user->update($fields);

        return redirect()->route('dashboard');
    }
}
