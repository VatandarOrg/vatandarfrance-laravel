<?php

namespace App\Http\Responses\Admin;

use App\Http\Responses\Admin\Permission\HtmlyResponses;
use App\Http\Responses\Admin\Permission\JsonResponses;
use Illuminate\Support\Facades\Facade;

/**
 * @method static index($permissions)
 * @method static invalidPermissionId()
 * @method static show($permission)
 * @method static store($permission)
 * @method static update($permission)
 * @method static destroy()
 * @method static storeFailed()
 * @method static updateFailed()
 * @method static destroyFailed()
 */
class PermissionResponse extends Facade
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
