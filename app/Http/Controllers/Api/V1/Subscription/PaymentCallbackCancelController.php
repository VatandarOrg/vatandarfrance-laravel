<?php

namespace App\Http\Controllers\Api\V1\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Subscription\PayPalSubscription;
use App\ProtectionLayers\EnsureSubscriptionPaymentIdExists;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;

class PaymentCallbackCancelController extends Controller
{
    protected $provider;

    public function __construct(PayPalSubscription $subscription)
    {
        EnsureSubscriptionPaymentIdExists::install();

        resolve(StartGuarding::class)->start();

        $this->provider = $subscription;
    }

    public function __invoke(Request $request)
    {
        HeyMan::checkPoint('EnsureSubscriptionPaymentIdExists');

        return $this->provider->callback($request);
    }
}
