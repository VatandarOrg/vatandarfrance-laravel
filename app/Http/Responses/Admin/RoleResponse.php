<?php

namespace App\Http\Responses\Admin;

use App\Http\Responses\Admin\Role\HtmlyResponses;
use App\Http\Responses\Admin\Role\JsonResponses;
use Illuminate\Support\Facades\Facade;

/**
 * @method static index($roles)
 * @method static invalidRoleId()
 * @method static show($role)
 * @method static store($role)
 * @method static update($role)
 * @method static destroy()
 * @method static storeFailed()
 * @method static updateFailed()
 * @method static destroyFailed()
 */
class RoleResponse extends Facade
{
    protected static function getFacadeAccessor()
    {
        $client = request('client');

        $class = [
            'mobile' => JsonResponses::class,
            'web' => HtmlyResponses::class
        ][$client] ?? HtmlyResponses::class;

        return $class;
    }
}
