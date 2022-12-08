<?php

namespace App\Http\Api\Controllers;

use App\Http\Requests\PlainRequest;

class PlainController
{
    public function __invoke(PlainRequest $request)
    {
        return response()->json([
            'cards' => [
                [
                    'key' => 'spatie-extra-info',
                    'components' => [
                        [
                            'componentLinkButton' => [
                                'linkButtonLabel' => 'View in Nova',
                                'linkButtonUrl' => 'https://spatie.be/nova/resources/users/4',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
