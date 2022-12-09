<?php

namespace App\Http\Api\Controllers;

use App\Http\Requests\HelpSpaceRequest;

class HelpspaceController
{
    public function __invoke(HelpSpaceRequest $request)
    {
        // Payload is the post request body.
// Secret is set in your webhook settings.

        // $payloadJson = json_encode($payload);

        // $signature = hash_hmac('sha256', $payloadJson, $secret);

        return response()->json(['html' => 'Hello there']);
    }
}
