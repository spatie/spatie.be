<?php

namespace App\Support;

use App\Models\Repository;

class RepositoryAccess
{
    /** @return array<int, string> */
    public static function restrictedNames(): array
    {
        return Repository::query()->where('visibility', '<>', 'public')->pluck('name')->all();
    }

    public static function isRestricted(string $name): bool
    {
        $visibility = Repository::query()->where('name', $name)->value('visibility');

        if ($visibility !== null) {
            return $visibility !== 'public';
        }

        return ! collect(config('docs.repositories'))->contains('name', $name);
    }

    public static function canViewRestricted(): bool
    {
        $user = auth()->user();

        // Registration and profile edits do not verify email ownership.
        return $user
            && str_ends_with(strtolower($user->email ?? ''), '@spatie.be')
            && $user->isSpatieMember();
    }

    public static function isRestrictedUrl(string $url): bool
    {
        $path = rawurldecode(parse_url($url, PHP_URL_PATH) ?? '');

        if (! preg_match('~^/(?:docs|packages/header|github-ad-image|github-ad-click)/([^/]+)~', $path, $matches)) {
            return false;
        }

        if (str_starts_with($path, '/github-ad-click/') && ! Repository::query()->where('name', $matches[1])->exists()) {
            return false;
        }

        return self::isRestricted(preg_replace('/\.jpg$/', '', $matches[1]));
    }
}
