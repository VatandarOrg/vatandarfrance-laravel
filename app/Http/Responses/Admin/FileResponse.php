<?php

namespace App\Http\Responses\Admin;

use App\Http\Responses\Admin\File\HtmlyResponses;
use App\Http\Responses\Admin\File\JsonResponses;
use Illuminate\Support\Facades\Facade;

/**
 * @method static index($files)
 * @method static invalidFileId()
 * @method static show($file)
 * @method static store($file)
 * @method static update($file)
 * @method static destroy()
 * @method static storeFailed($message)
 * @method static updateFailed()
 * @method static destroyFailed()
 */
class FileResponse extends Facade
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
