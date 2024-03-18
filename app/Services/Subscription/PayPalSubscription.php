<?php

namespace App\Services\Subscription;

use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Services\SubscriptionPayment\SubscriptionPaymentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;

class PayPalSubscription
{
    public function create()
    {
        $data = [
            "plan_id" => env('PAYPAL_PRODUCT_ID'),
            'shipping_amount' => [
                'currency_code' => 'EUR',
                'value' => "10.00",
            ],
            'subscriber' => [
                'name' => [
                    'full_name' => auth()->user()->full_name,
                    'username' => auth()->user()->username,
                ]
            ],
            'application_context' => [
                'brand_name' => 'vatandar',
                'locale' => 'en-US',
                'return_url' => route('subscription.callback'),
                'cancel_url' => route('subscription.callback.cancel'),
            ],
        ];

        $response = Http::acceptJson()->withBasicAuth(env('PAYPAL_SANDBOX_CLIENT_ID'), env('PAYPAL_SANDBOX_CLIENT_SECRET'))->post('https://api-m.sandbox.paypal.com/v1/billing/subscriptions', $data);

        $response = $response->json();

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    SubscriptionPaymentService::new()
                        ->create(['user_id' => auth()->id(), 'paypal_subscription_id' => $response['id'], 'status' => $response['status'], 'plan_id' => env('PAYPAL_PRODUCT_ID')]);
                    return $link['href'];
                    return redirect($link['href']);
                }
            }

            return response()->json(["status" => "error", "message" => 'Something went wrong.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            return response()->json(["status" => "error", "message" => $response['message'] ?? 'Something went wrong.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function callback($request)
    {
        $payment = SubscriptionPayment::where('paypal_subscription_id', $request['subscription_id'])->firstOrFail();
        $response = Http::acceptJson()->withBasicAuth(env('PAYPAL_SANDBOX_CLIENT_ID'), env('PAYPAL_SANDBOX_CLIENT_SECRET'))->get('https://api-m.sandbox.paypal.com/v1/billing/subscriptions/' . $payment['paypal_subscription_id'])->json();
        if ($response['status'] == 'ACTIVE') {
            SubscriptionPaymentService::make($payment)
                ->afterCallback(function (SubscriptionPayment $payment, SubscriptionPaymentService $service) {
                    SubscriptionService::new()->create(['user_id' => $payment->user_id, 'payment_id' => $payment->id, 'expired_at' => $payment->expired_at])->getOrSend(function () {
                        return response()->json(["status" => "error", "message" => 'Something went wrong.'], Response::HTTP_METHOD_NOT_ALLOWED);
                    });
                })
                ->update([
                    'callback_data' => json_encode($request),
                    'status' => $response['status'],
                    'start_time' => Carbon::create($response['create_time']),
                    'subscriber' => json_encode($response['subscriber']),
                    'detail' => json_encode($response),
                    'expired_at' => Carbon::create($response['create_time'])->addYear(),
                ])->getOrSend(function () {
                    return response()->json(["status" => "error", "message" => 'Something went wrong.'], Response::HTTP_METHOD_NOT_ALLOWED);
                });
            return response()->json(["status" => "success", "message" => 'subscription active successfully!'], Response::HTTP_OK);
        } else {
            SubscriptionPaymentService::make($payment)
                ->update([
                    'callback_data' => json_encode($request),
                    'status' => $response['status'],
                    'detail' => json_encode($response),
                ]);
            return response()->json(["status" => "error", "message" => 'payment status: ' . $response['status']], Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }

    public function cancel($subscription_id)
    {
        $data = [
            'reason' => 'cancel by user'
        ];

        $payment = SubscriptionPayment::where('paypal_subscription_id', $subscription_id)->first();

        $response = Http::acceptJson()->withBasicAuth(env('PAYPAL_SANDBOX_CLIENT_ID'), env('PAYPAL_SANDBOX_CLIENT_SECRET'))->post('https://api-m.sandbox.paypal.com/v1/billing/subscriptions/' . $subscription_id . '/suspend', $data);

        if ($response->status() == 204) {
            $response = Http::acceptJson()->withBasicAuth(env('PAYPAL_SANDBOX_CLIENT_ID'), env('PAYPAL_SANDBOX_CLIENT_SECRET'))->get('https://api-m.sandbox.paypal.com/v1/billing/subscriptions/' . $payment['paypal_subscription_id'])->json();
            SubscriptionPaymentService::make($payment)
                ->afterCallback(function (SubscriptionPayment $payment, SubscriptionPaymentService $service) {
                    SubscriptionService::make(auth()->user()->subscription)->delete();
                })
                ->update([
                    'status' => $response['status'],
                    'detail' => json_encode($response),
                    'expired_at' => now(),
                ])->getOrSend(function () {
                    return response()->json(["status" => "error", "message" => 'Something went wrong.'], Response::HTTP_METHOD_NOT_ALLOWED);
                });
            return response()->json(["status" => "success", "message" => 'payment status: ' . $response['status']], Response::HTTP_OK);
        }
        return response()->json(["status" => "error", "message" => 'Something went wrong.'], Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
