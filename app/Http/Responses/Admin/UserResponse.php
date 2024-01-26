<?php
namespace App\Http\Responses\Admin;
use App\Http\Responses\Admin\User\HtmlyResponses;
use App\Http\Responses\Admin\User\JsonResponses;
use Illuminate\Support\Facades\Facade;
class UserResponse extends Facade
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
