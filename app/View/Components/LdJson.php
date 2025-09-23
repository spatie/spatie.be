<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\LaravelUrlAiTransformer\Models\TransformationResult;

class LdJson extends Component
{
    public function render(): View|Closure|string
    {
        $url = request()->url();

        if (request()->path() === '/') {
            $url .= '/';
        }

        $result = TransformationResult::forUrl($url, 'ldJson');

        if (! $result) {
            return '';
        }

        return view('components.ld-json', [
            'ldJsonContent' => $result,
        ]);
    }
}
