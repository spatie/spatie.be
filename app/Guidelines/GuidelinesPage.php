<?php

namespace App\Guidelines;

use Illuminate\Support\HtmlString;
use Spatie\Sheets\Sheet;

class GuidelinesPage extends Sheet
{
    public function getTocAttribute(): HtmlString
    {
        return new HtmlString(
            explode('</ul>', $this->attributes['contents'], 2)[0] . '</ul>'
        );
    }

    public function getContentsAttribute(): HtmlString
    {
        return new HtmlString(
            explode('</ul>', $this->attributes['contents'], 2)[1] ?? ''
        );
    }
}
