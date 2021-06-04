<?php

namespace App\Http\Controllers;

use App\Models\Technology;

class UsesController
{
    public function index()
    {
        $technologies = Technology::all()
            ->groupBy(fn (Technology $tech) => $tech->type->value);

        return view('front.pages.uses.index', compact('technologies'));
    }
}
