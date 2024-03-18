<?php

namespace App\Http\Responses\Admin\SubscriptionPayment;

class HtmlyResponses
{
    public function index($subscription_payments)
    {
        return view('admin.subscriptionpayments.index', compact('subscription_payments'));
    }
    public function show($subscriptionpayment)
    {
        return view('admin.subscriptionpayments.show', compact('subscriptionpayment'));
    }
    public function invalidSubscriptionPaymentId()
    {
        return redirect()->back()->with(['danger-custom' => __("SubscriptionPayment مورد نظر یافت نشد."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function destroy()
    {
        return redirect()->back()->with(['success-custom' => __("SubscriptionPayment با موفقیت حذف شد."), 'title' => 'test']);
    }

    public function destroyFailed()
    {
        return redirect()->back()->with(['danger-custom' => __("در روند حذف SubscriptionPayment مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
}
