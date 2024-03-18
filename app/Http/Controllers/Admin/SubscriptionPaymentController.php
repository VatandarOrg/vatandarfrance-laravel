<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\Admin\SubscriptionPaymentResponse;
use App\ProtectionLayers\EnsureSubscriptionPaymentIdExists;
use App\Services\SubscriptionPayment\SubscriptionPaymentService;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;

class SubscriptionPaymentController extends Controller
{
    public function __construct()
    {
        EnsureSubscriptionPaymentIdExists::install();
        resolve(StartGuarding::class)->start();
    }
    public function index()
    {
        request()->pagination = 10;
        $subscription_payments = SubscriptionPaymentService::new()->allWithRelation();
        return SubscriptionPaymentResponse::index($subscription_payments);
    }
    public function show($id)
    {
        $subscriptionpayment = SubscriptionPaymentService::new()->findByIdWithRelation($id);
        return SubscriptionPaymentResponse::show($subscriptionpayment);
    }
    public function destroy($id)
    {
        HeyMan::checkPoint('EnsureSubscriptionPaymentIdExists');
        SubscriptionPaymentService::make(SubscriptionPaymentService::new()->findByIdWithRelation($id))->delete()
            ->getOrSend([SubscriptionPaymentResponse::class, 'destroyFailed']);
        return SubscriptionPaymentResponse::destroy();
    }
}
