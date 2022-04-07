<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Contracts\ImpersonatesUsers;

class StopImpersonationController
{
    public function __invoke(Request $request, ImpersonatesUsers $impersonator)
    {
        if (! $impersonator->impersonating($request)) {
            return back();
        }

        $userId = auth()->user()->id;

        $impersonator->stopImpersonating($request, Auth::guard(), User::class);

        return redirect()->to("/nova/resources/users/{$userId}");
    }
}
