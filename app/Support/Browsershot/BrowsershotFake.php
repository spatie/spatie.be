<?php

namespace App\Support\Browsershot;

class BrowsershotFake extends Browsershot
{
    public function screenshot(): string
    {
        return '';
    }

    public function pdf(): string
    {
        return '';
    }
}
