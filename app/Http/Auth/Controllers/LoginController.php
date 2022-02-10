<?php

namespace App\Http\Auth\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Request $request)
    {
        $previous = url()->previous();

        if (Str::finish($previous, '/') === Str::finish(url('/'), '/')) {
            $previous = route('products.index');
        }

        session()->flash('next', $previous);

        $this->onlyAllowSpatieRedirects($request);

        return view('auth.login');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        flash()->success('You are now logged in');

        return redirect()->to(session()->get('next', route('products.index')));
    }

    private function onlyAllowSpatieRedirects(Request $request): void
    {
        if ($request->get('next') !== null &&
            $request->getHttpHost() === parse_url($request->get('next'))['host']
        ) {
            session()->flash('next', $request->get('next'));
        }
    }
}
