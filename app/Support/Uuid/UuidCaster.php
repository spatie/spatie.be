<?php

namespace App\Support\Uuid;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class UuidCaster implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        return Uuid::make($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (! $value instanceof Uuid) {
            return $value;
        }

        return (string) $value;
    }
}
