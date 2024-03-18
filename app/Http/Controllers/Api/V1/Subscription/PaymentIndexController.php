<?php

namespace App\Http\Controllers\Api\V1\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Payment\PaymentWithoutRelationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json(["status" => "success", "payments" => PaymentWithoutRelationResource::collection(auth()->user()->payments()->orderByDesc('created_at')->get())], Response::HTTP_OK);
    }
}
