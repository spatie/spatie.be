<?php

namespace App\Http\Api\Controllers;

use App\Models\Member;

class MembersController
{
    public function index()
    {
        $members = Member::all()
            ->map(fn (Member $member) => [
                'name' => $member->name(),
                'twitter' => $member->twitter,
                'website' => $member->website,
            ]);

        return response($members);
    }
}
