<?php

namespace App\Docs\Highlighting;

use Tempest\Highlight\Languages\Php\PhpLanguage;

class DiffLanguage extends PhpLanguage
{
    public function getName(): string
    {
        return 'diff';
    }

    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new DiffAdditionInjection(),
            new DiffDeletionInjection(),
        ];
    }
}
