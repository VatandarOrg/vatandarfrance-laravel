<?php

namespace App\Http\Responses\Admin;

use App\Http\Responses\Admin\SubscriptionPayment\HtmlyResponses;
use App\Http\Responses\Admin\SubscriptionPayment\JsonResponses;
use Illuminate\Support\Facades\Facade;

class SubscriptionPaymentResponse extends Facade
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
