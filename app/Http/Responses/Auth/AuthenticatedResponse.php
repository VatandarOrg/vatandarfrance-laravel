<?php

namespace App\Http\Responses\Auth;

use App\Http\Responses\Auth\Authenticated\HtmlyResponses;
use App\Http\Responses\Auth\Authenticated\JsonResponses;
use Illuminate\Support\Facades\Facade;

/**
 * @method static loginOrSignup($register)
 * @method static isValid($isValid)
 * @method static login($user, $token)
 * @method static me($user)
 * @method static registerFailed()
 * @method static update($user)
 * @method static updateFailed()
 * @method static createFailed()
 * @method static changePasswordFailed()
 * @method static changePassword()
 * @method static destroy()
 * @method static destroyFailed()
 */
class AuthenticatedResponse extends Facade
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
