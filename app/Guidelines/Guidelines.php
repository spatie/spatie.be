<?php

namespace App\Guidelines;

use Illuminate\Support\Collection;
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

    public function page(string $slug): ?GuidelinesPage
    {
        return $this->pages->firstWhere('slug', $slug);
    }
}
