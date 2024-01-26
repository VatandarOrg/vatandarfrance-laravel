<?php

namespace App\Http\Responses\Auth;

use App\Http\Responses\Auth\TwoFactor\HtmlyResponses;
use App\Http\Responses\Auth\TwoFactor\JsonResponses;
use Illuminate\Support\Facades\Facade;

/**
 * @method static confirmCode($token, $roles, $register, $user, $device)
 * @method static resendCode()
 * @method static refuseCode()
 * @method static userNotFound()
 */
class TwoFactorResponse extends Facade
{
    protected static function getFacadeAccessor()
    {
        $client = request('client');

        $class = [
            'mobile' => JsonResponses::class,
            'web' => HtmlyResponses::class
        ][$client] ?? JsonResponses::class;

        return $class;
    }
}
