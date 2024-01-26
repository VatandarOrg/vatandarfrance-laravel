<?php

namespace App\Http\Responses\Admin\Permission;

use Illuminate\Http\Response;

class JsonResponses
{
    public function index($permissions)
    {
        return response()->json(["status" => "success", "permissions" => $permissions], Response::HTTP_OK);
    }

    public function invalidPermissionId()
    {
        return response()->json(["status" => "error", "message" => __('message.invalidId', ['model' => __('message.model.permission')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function show($permission)
    {
        return response()->json(["status" => "success", "permission" => $permission], Response::HTTP_OK);
    }

    public function store($permission)
    {
        return response()->json(["status" => "success", "message" => __('message.store', ['model' => __('message.model.permission')]), "permission" => $permission], Response::HTTP_CREATED);
    }

    public function update($permission)
    {
        return response()->json(["status" => "success", "message" => __('message.update', ['model' => __('message.model.permission')]), "permission" => $permission], Response::HTTP_ACCEPTED);
    }
    
    public function destroy()
    {
        return response()->json(["status" => "success", "message" => __('message.destroy', ['model' => __('message.model.permission')])], Response::HTTP_ACCEPTED);
    }

    public function storeFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.storeFailed', ['model' => __('message.model.permission')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function updateFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.updateFailed', ['model' => __('message.model.permission')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function destroyFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.destroyFailed', ['model' => __('message.model.permission')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
