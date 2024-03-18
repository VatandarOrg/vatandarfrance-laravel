<?php

namespace App\Http\Controllers\Api\V1\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Subscription\PayPalSubscription;
use App\ProtectionLayers\EnsureUserCanBuySubscription;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;

class PaymentCreateController extends Controller
{
    protected $provider;

    public function __construct(PayPalSubscription $subscription)
    {
        EnsureUserCanBuySubscription::install();

        resolve(StartGuarding::class)->start();

        $this->provider = $subscription;
    }

    public function __invoke(Request $request)
    {
        // HeyMan::checkPoint('EnsureUserCanBuySubscription');

        return $this->provider->create();
    }
}
