<?php

namespace App\Http\Api\Controllers;

use App\Http\Requests\HelpSpaceRequest;
use App\Models\User;

class HelpSpaceController
{
    public function __invoke(HelpSpaceRequest $request)
    {
        $user = User::firstWhere('email', $request->email());

        if (! $user) {
            return 'No user found at spatie.be';
        }

        // $userInfo = view('add-view');

        $userInfo = 'hello there';

        return response()->json(['html' => $userInfo]);
    }
}
