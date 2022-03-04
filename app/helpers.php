<?php

use App\Models\Image;
use App\Models\User;
use App\Services\Schema\Schema;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\HtmlString;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

function svg($filename): HtmlString
{
    return new HtmlString(
        file_get_contents(resource_path("svg/{$filename}.svg"))
    );
}

function image(string $path): ?Media
{
    $image = Image::findByPath($path);

    try {
        if (! $image) {
            $image = Image::createWithPath($path);
        }

        return $image->getFirstMedia();
    } catch (Exception $exception) {
        report($exception);

        return null;
    }
}

function is_office_open(): bool
{
    if (! now()->isWeekday()) {
        return false;
    }

    $startTime = now()->hour(9)->minute(0);
    $endTime = now()->hour(17)->minute(30);

    return now()->between($startTime, $endTime);
}

function gravatar_img(string $name): HtmlString
{
    $gravatarId = md5(strtolower(trim($name)));

    return new HtmlString('<img src="https://gravatar.com/avatar/' . $gravatarId . '?s=240">');
}

function faker(): Generator
{
    return Factory::create();
}

function mailto(string $subject, string $body): string
{
    $subject = rawurlencode(htmlspecialchars_decode($subject));

    $body = rawurlencode(htmlspecialchars_decode($body));

    return "mailto:info@spatie.be?subject={$subject}&body={$body}";
}

function schema(): Schema
{
    return app(Schema::class);
}


function formatBytes($size, $precision = 2)
{
    $base = log((float) $size, 1024);
    $suffixes = ['', 'K', 'M', 'G', 'T'];

    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}

function sponsorIsViewingPage(): bool
{
    if (! auth()->user()) {
        return false;
    }

    return auth()->user()->isSponsoring();
}

function current_user(): ?User
{
    return auth()->user();
}

function command(object $command): void
{
    $bus = app(CommandBus::class);

    $bus->dispatch($command);
}
