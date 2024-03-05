<?php

namespace App\Filament\Resources\Content\MemberResource\Pages;

use App\Filament\Resources\Content\MemberResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMember extends CreateRecord
{
    protected static string $resource = MemberResource::class;
}
