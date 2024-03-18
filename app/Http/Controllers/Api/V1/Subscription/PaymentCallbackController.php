<?php

namespace App\Http\Controllers\Api\V1\Subscription;

use App\Http\Controllers\Controller;
use App\ProtectionLayers\EnsureSubscriptionPaymentIdExists;
use Illuminate\Http\Request;
use App\Services\Subscription\PayPalSubscription;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;

class PaymentCallbackController extends Controller
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
