<?php
namespace App\Http\Responses\Admin;
use App\Http\Responses\Admin\Slider\HtmlyResponses;
use App\Http\Responses\Admin\Slider\JsonResponses;
use Illuminate\Support\Facades\Facade;
class SliderResponse extends Facade
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
