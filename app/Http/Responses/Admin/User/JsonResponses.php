<?php
namespace App\Http\Responses\Admin\User;
use Illuminate\Http\Response;
class JsonResponses
{
    public function index($users)
    {
        return response()->json(["status" => "success", "users" => $users], Response::HTTP_OK);
    }
    public function invalidUserId()
    {
        return response()->json(["status" => "error", "message" => __('message.invalidId', ['model' => __('message.model.user')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function show($user)
    {
        return response()->json(["status" => "success", "user" => $user], Response::HTTP_OK);
    }
    public function store($user)
    {
        return response()->json(["status" => "success", "message" => __('message.store', ['model' => __('message.model.user')]), "user" => $user], Response::HTTP_CREATED);
    }
    public function update($user)
    {
        return response()->json(["status" => "success", "message" => __('message.update', ['model' => __('message.model.user')]), "user" => $user], Response::HTTP_ACCEPTED);
    }
    public function destroy()
    {
        return response()->json(["status" => "success", "message" => __('message.destroy', ['model' => __('message.model.user')])], Response::HTTP_ACCEPTED);
    }
    public function storeFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.storeFailed', ['model' => __('message.model.user')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function updateFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.updateFailed', ['model' => __('message.model.user')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function destroyFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.destroyFailed', ['model' => __('message.model.user')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
