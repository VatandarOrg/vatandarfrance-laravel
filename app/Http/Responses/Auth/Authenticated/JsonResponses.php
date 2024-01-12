<?php

namespace App\Http\Responses\Auth\Authenticated;

use Illuminate\Http\Response;
use App\Http\Resources\Api\V1\User\UserWithoutRelationResource;

class JsonResponses
{
    public function loginOrSignup($register)
    {
        return response()->json([
            "isRegister" => $register,
        ], Response::HTTP_OK);
    }

    public function isValid($isValid)
    {
        return response()->json([
            "isValid" => $isValid,
        ], Response::HTTP_OK);
    }

    public function login($user, $token)
    {
        return response()->json([
            "status" => "success",
            "message" => __('message.store', ['model' => __('message.model.user')]),
            "token" => $token->plainTextToken,
            "user" => UserWithoutRelationResource::make($user),
        ], Response::HTTP_OK);
    }

    public function me($user)
    {
        return response()->json([
            "status" => "success",
            "user" => UserWithoutRelationResource::make($user),
        ], Response::HTTP_OK);
    }
    public function registerFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.storeFailed', ['model' => __('message.model.user')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function update($user)
    {
        return response()->json(["status" => "success", "message" => __('message.update', ['model' => __('message.model.user')]), "user" => $user], Response::HTTP_ACCEPTED);
    }
    public function updateFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.updateFailed', ['model' => __('message.model.user')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function createFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.storeFailed', ['model' => __('message.model.user')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function changePasswordFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.changePasswordFailed')], Response::HTTP_ACCEPTED);
    }
    public function changePassword()
    {
        return response()->json(["status" => "success", "message" => __('message.changePassword')], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function destroy()
    {
        return response()->json(["status" => "success", "message" => __('message.destroy', ['model' => __('message.model.user')])], Response::HTTP_ACCEPTED);
    }
    public function destroyFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.destroyFailed', ['model' => __('message.model.user')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
