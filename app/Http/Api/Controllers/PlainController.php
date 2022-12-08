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
                    'timeToLiveSeconds' => null,
                    'components' => [
                        'componentContainer' => [
                            'containerContent' => [
                                'componentSpacer' => [
                                    'spacerSize' => 'S',
                                ],
                                'componentRow' => [
                                    'rowMainContent' => [
                                        'textSize' => 'M',
                                        'textColor' => 'NORMAL',
                                        'text' => 'My order text for' . $request->email(),
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
