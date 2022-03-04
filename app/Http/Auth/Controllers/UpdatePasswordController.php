<?php

namespace App\Http\Auth\Controllers;

use App\Rules\MatchCurrentPasswordRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController
{
    public function show()
    {
        return view('front.profile.password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchCurrentPasswordRule()],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        flash()->success('Password updated successfully.');

        return redirect()->route('profile.password');
    }
}
