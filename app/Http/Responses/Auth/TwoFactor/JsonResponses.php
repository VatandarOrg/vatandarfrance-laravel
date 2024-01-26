<?php

namespace App\Http\Responses\Auth\TwoFactor;

use App\Http\Resources\Api\V1\Device\DeviceWithoutRelationResource;
use App\Http\Resources\Api\V1\Role\RoleResource;
use App\Http\Resources\Api\V1\User\UserWithoutRelationResource;
use Illuminate\Http\Response;

class JsonResponses
{
    public function confirmCode($token, $roles, $user)
    {
        return response()->json(["status" => "success", "token" => $token->plainTextToken, 'user' => UserWithoutRelationResource::make($user)], Response::HTTP_CREATED);
    }

    public function resendCode()
    {
        return response()->json(["status" => "success", "message" => 'کد جدید به شمارهٔ موبایل‌تان ارسال شد.'], Response::HTTP_OK);
    }

    public function refuseCode()
    {
        return response()->json(["status" => "error", "message" => __('message.invalidId', ['model' => __('message.model.code')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function userNotFound()
    {
        return response()->json(["status" => "error", "message" => __('message.invalidId', ['model' => __('message.model.user')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
