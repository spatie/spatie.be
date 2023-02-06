<?php

namespace App\Http\Controllers;

use App\Models\Technology;

class UsesController
{
    public function index()
    {
        $technologies = Technology::query()
            ->orderBy('type')
            ->orderBy('sort_order')
            ->get()
            ->groupBy(fn (Technology $tech) => $tech->type?->value);

        return view('front.pages.uses.index', compact('technologies'));
    }
}
