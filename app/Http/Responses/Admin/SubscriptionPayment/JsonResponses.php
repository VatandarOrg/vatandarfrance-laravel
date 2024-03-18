<?php
namespace App\Http\Responses\Admin\SubscriptionPayment;
use App\Http\Resources\Api\V1\SubscriptionPayment\SubscriptionPaymentWithoutRelationResource;
use Illuminate\Http\Response;
class JsonResponses
{
    public function index($subscription_payments)
    {
        return response()->json(["status" => "success", "subscription_payments" => SubscriptionPaymentWithoutRelationResource::collection($subscription_payments)], Response::HTTP_OK);
    }
    public function invalidSubscriptionPaymentId()
    {
        return response()->json(["status" => "error", "message" => __('message.invalidId', ['model' => __('message.model.subscriptionpayment')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function show($subscriptionpayment)
    {
        return response()->json(["status" => "success", "subscriptionpayment" => SubscriptionPaymentWithoutRelationResource::make($subscriptionpayment)], Response::HTTP_OK);
    }
    public function store($subscriptionpayment)
    {
        return response()->json(["status" => "success", "message" => __('message.store', ['model' => __('message.model.subscriptionpayment')]), "subscriptionpayment" => SubscriptionPaymentWithoutRelationResource::make($subscriptionpayment)], Response::HTTP_CREATED);
    }
    public function update($subscriptionpayment)
    {
        return response()->json(["status" => "success", "message" => __('message.update', ['model' => __('message.model.subscriptionpayment')]), "subscriptionpayment" => SubscriptionPaymentWithoutRelationResource::make($subscriptionpayment)], Response::HTTP_ACCEPTED);
    }
    public function destroy()
    {
        return response()->json(["status" => "success", "message" => __('message.destroy', ['model' => __('message.model.subscriptionpayment')])], Response::HTTP_ACCEPTED);
    }
    public function storeFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.storeFailed', ['model' => __('message.model.subscriptionpayment')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function updateFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.updateFailed', ['model' => __('message.model.subscriptionpayment')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function destroyFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.destroyFailed', ['model' => __('message.model.subscriptionpayment')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
