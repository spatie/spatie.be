<?php

namespace App\Http\Middleware;

use App\Models\Referrer;
use Closure;
use Illuminate\Http\Request;

class HandleReferrer
{
    public function handle(Request $request, Closure $next)
    {
        if ($referrer = $request->referrer) {
            /** @var Referrer $referrer */
            if ($referrer = Referrer::firstWhere(['slug' => $referrer])) {

                $referrer
                    ->registerClick()
                    ->makeActive();
            }
        }

        return $next($request);
    }
}
