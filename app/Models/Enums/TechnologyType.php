<?php

namespace App\Models\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self frontend()
 * @method static self backend()
 * @method static self devops()
 * @method static self tools()
 */
class TechnologyType extends Enum
{
    public static function toLabels(): array
    {
        return [
            'frontend'=> 'Frontend',
            'backend' => 'Backend',
            'devops' => 'Devops',
            'tools' => 'Tools',
        ];
    }
}
