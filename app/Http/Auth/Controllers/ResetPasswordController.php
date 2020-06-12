<?php

namespace App\Http\Auth\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ResetPasswordController
{
    use ResetsPasswords, AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }
}
