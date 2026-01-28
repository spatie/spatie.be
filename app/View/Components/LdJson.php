<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\View\Component;
use Spatie\LaravelUrlAiTransformer\Models\TransformationResult;

class LdJson extends Component
{
    public function render(): View|Closure|string
    {
        $url = $this->getUrl();

        $result = TransformationResult::forUrl($url, 'ldJson');

        if (! $result) {
            return '';
        }

        return view('components.ld-json', [
            'ldJsonContent' => $this->sanitize($result),
        ]);
    }

    protected function getUrl(): string
    {
        $url = request()->path();

        if (request()->path() !== '/') {
            $url .= '/';
        }

        return $url;
    }

    protected function sanitize(string $result): Stringable
    {
        $result = Str::of($result)
            ->trim()
            ->after('```json')
            ->trim('`')
            ->trim();

        return $result;
    }
}
