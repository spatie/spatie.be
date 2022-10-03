<?php

namespace App\Http\Api\Controllers;

use App\Models\Member;

class MembersController
{
    public function index()
    {

        $members = Member::all()
            ->map(fn (Member $member) => ['name' => $member->name()]);

        return response($members);
    }
}
