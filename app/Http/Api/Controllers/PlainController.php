<?php

namespace App\Http\Api\Controllers;

use App\Http\Requests\PlainRequest;
use App\Models\User;

class PlainController
{
    public function __invoke(PlainRequest $request)
    {
        $user = User::firstWhere('email', $request->email())?->email;

        if (! $user) {
            return response()->json([
                'cards' => [
                    [
                        'key' => 'spatie-extra-info',
                        'components' => [
                            [
                                'componentText' => [
                                    'text' => 'No user found at Spatie',
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
        }

        return response()->json([
            'cards' => [
                [
                    'key' => 'spatie-extra-info',
                    'components' => [
                        [
                            'componentText' => [
                                'text' => 'Name',
                                'textColor' => 'Muted',
                                'textSize' => 'S',
                            ],
                        ],
                        [
                            'componentText' => [
                                'text' => $user->name,
                            ],
                        ],
                        [
                            'componentDivider' => [
                                'dividerSpacingSize' => 'M',
                            ],
                        ],
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
