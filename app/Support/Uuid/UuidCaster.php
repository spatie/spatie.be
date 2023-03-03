<?php

namespace App\Support\Uuid;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class UuidCaster implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        return Uuid::make($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if (! $value instanceof Uuid) {
            return $value;
        }

        return (string) $value;
    }
}
