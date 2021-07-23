<?php

namespace App\Models\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self frontend()
 * @method static self backend()
 * @method static self services()
 * @method static self apps()
 */
class TechnologyType extends Enum
{
    public static function toLabels(): array
    {
        return [
            'frontend'=> 'Frontend',
            'backend' => 'Backend',
            'services' => 'Services',
            'apps' => 'Desktop apps',
        ];
    }
}
