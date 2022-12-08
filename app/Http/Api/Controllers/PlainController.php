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
                    "key" => "spatie-extra-info",
                    "timeToLiveSeconds" => 86400,
                    "components" => [
                        [
                            "componentRow" => [
                                "rowMainContent" => [
                                    [
                                        "componentText" => [
                                            "text" => "Plan",
                                            "textColor" => "MUTED",
                                            "textSize" => "M",
                                        ],
                                    ],
                                ],
                                "rowAsideContent" => [
                                    [
                                        "componentBadge" => [
                                            "badgeLabel" => "Starter",
                                            "badgeColor" => "YELLOW",
                                        ],
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
