<?php

namespace App\Filament\Resources\Customers\UserResource\Pages;

use App\Filament\Resources\Customers\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
