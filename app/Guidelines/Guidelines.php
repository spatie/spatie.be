<?php

namespace App\Guidelines;

use Illuminate\Support\Collection;
use Spatie\Sheets\Sheet;
use Spatie\Sheets\Sheets;

class Guidelines
{
    private Collection $pages;

    public function __construct(Sheets $sheets)
    {
        $this->pages = resolve(ResolveGuidelinesAction::class)->execute();
    }

    public function pages(): Collection
    {
        return $this->pages;
    }

    public function page(string $slug): ?Sheet
    {
        $page = $this->pages->firstWhere('slug', $slug);

        if ($page) {
            return $page;
        }

        $renamedSlug = $this->findRenamedSlugs($slug);

        return $renamedSlug
            ? $this->pages->firstWhere('slug', $renamedSlug)
            : null;
    }

    protected function findRenamedSlugs(string $slug): ?string
    {
        return match ($slug) {
            'laravel-php' => 'laravel',
            default => null,
        };
    }
}
