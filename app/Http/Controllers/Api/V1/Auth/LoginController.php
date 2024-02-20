<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Responses\Auth\AuthenticatedResponse;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $request->mergeIfMissing(['mobile' => $request->username]);
        $request->mergeIfMissing(['email' => $request->username]);

        $request->authenticate();

        $user = auth()->user();

        $token = $user->createToken($user['username']);

        return AuthenticatedResponse::login($user, $token);
    }
}
