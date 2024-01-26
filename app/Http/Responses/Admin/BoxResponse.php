<?php

namespace App\Http\Responses\Admin;

use App\Http\Responses\Admin\Box\HtmlyResponses;
use App\Http\Responses\Admin\Box\JsonResponses;
use Illuminate\Support\Facades\Facade;

class BoxResponse extends Facade
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
