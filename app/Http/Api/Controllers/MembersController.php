<?php

namespace App\Http\Api\Controllers;

use App\ValueObjects\TeamMember;

class MembersController
{
    public function index()
    {

        $members = collect(config('team.members'))
            ->map(fn (array $member) => TeamMember::make($member)->toArray());

        return response($members);
    }
}
