<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('SubscriptionPayment') }}
            </h2>
        </div>
        @include('partials.alert')
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0 mb-5">
                <h3 class="text-lg font-semibold leading-6 text-gray-900">اطلاعات پرداخت
                    {{ $subscriptionpayment->paypal_subscription_id }}</h3>
            </div>
            <div class="shadow-md overflow-hidden sm:rounded-lg p-4 border bg-white">
                <div class="mt-6 border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">کاربر</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $subscriptionpayment->user->username }}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">plan_id : </dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $subscriptionpayment->plan_id }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">Status</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                @if ($subscriptionpayment->status == 'ACTIVE')
                                    <span
                                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $subscriptionpayment->status }}</span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">{{ $subscriptionpayment->status }}</span>
                                @endif
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">اطلاعات پرداخت کننده:</dt>
                            <pre dir="ltr" id="subjson" class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $subscriptionpayment->subscriber }}</pre>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">جزییات پرداخت :</dt>
                            <pre dir="ltr" id="detailjson" class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $subscriptionpayment->detail }}</pre>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <script>
        var subtext = document.getElementById('subjson');
        var subobj = JSON.parse(subtext.innerHTML);
        subtext.innerHTML = JSON.stringify(subobj, undefined, 2);

        var detailtext = document.getElementById('detailjson');
        var detailobj = JSON.parse(detailtext.innerHTML);
        detailtext.innerHTML = JSON.stringify(detailobj, undefined, 2);
    </script>
</x-app-layout>
