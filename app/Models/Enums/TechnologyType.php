<?php

namespace App\Models\Enums;

use Livewire\Wireable;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self frontend()
 * @method static self backend()
 * @method static self services()
 * @method static self apps()
 */
class TechnologyType extends Enum implements Wireable
{
    public static function toLabels(): array
    {
        return [
            'frontend' => 'Frontend',
            'backend' => 'Backend',
            'services' => 'Services',
            'apps' => 'Desktop apps',
        ];
    }

    public function toLivewire()
    {
        return [$this->value];
    }

    public static function fromLivewire($value)
    {
        return new self($value[0]);
    }
}
