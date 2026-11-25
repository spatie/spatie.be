<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminAccess extends Model
{
    protected $guarded = [];

    public function revoke(): bool
    {
        return DB::transaction(function (): bool {
            $addresses = static::query()->orderBy('id')->lockForUpdate()->get();

            if ($addresses->count() <= 1) {
                throw ValidationException::withMessages([
                    'email' => 'Add another address before removing the last administrator.',
                ]);
            }

            return (bool) $this->delete();
        });
    }
}
