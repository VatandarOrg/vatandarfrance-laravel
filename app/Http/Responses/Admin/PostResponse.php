<?php

namespace App\Http\Responses\Admin;

use App\Http\Responses\Admin\Post\HtmlyResponses;
use App\Http\Responses\Admin\Post\JsonResponses;
use Illuminate\Support\Facades\Facade;

class PostResponse extends Facade
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
