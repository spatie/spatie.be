<?php

namespace App\Http\Middleware;

class CheckForMaintenanceMode extends PreventRequestsDuringMaintenance
{
    protected $except = [
        '/paddle/webhook'
    ];
}
