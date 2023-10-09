<?php

namespace App\Http\Auth\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ApiTokensController
{
    public function create(Request $request): array
    {
        $user = $request->user();

        if ($user === null || ! $user->isSpatieMember()) {
            throw new BadRequestHttpException('You are not a Spatie member');
        }

        $token = $user->createToken('api-token');

        return ['token' => $token->plainTextToken];
    }
}
