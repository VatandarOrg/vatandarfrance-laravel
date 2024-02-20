<?php
namespace App\Http\Responses\User;
use App\Http\Responses\User\Post\HtmlyResponses;
use App\Http\Responses\User\Post\JsonResponses;
use Illuminate\Support\Facades\Facade;
class PostResponse extends Facade
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
