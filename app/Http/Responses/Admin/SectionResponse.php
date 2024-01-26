<?php
namespace App\Http\Responses\Admin;
use App\Http\Responses\Admin\Section\HtmlyResponses;
use App\Http\Responses\Admin\Section\JsonResponses;
use Illuminate\Support\Facades\Facade;
class SectionResponse extends Facade
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
