<?php

namespace App\Domain\Shop\Enums;

enum SeriesType: string
{
    case Video = 'video';
    case VideoAndEbook = 'video_and_ebook';
    case Html = 'html';
}
