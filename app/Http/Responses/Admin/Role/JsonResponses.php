<?php

namespace App\Http\Responses\Admin\Role;

use Illuminate\Http\Response;

class JsonResponses
{
    public function index($roles)
    {
        return response()->json(["status" => "success", "roles" => $roles], Response::HTTP_OK);
    }

    public function invalidRoleId()
    {
        return response()->json(["status" => "error", "message" => __('message.invalidId', ['model' => __('message.model.role')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function show($role)
    {
        return response()->json(["status" => "success", "role" => $role], Response::HTTP_OK);
    }

    public function store($role)
    {
        return response()->json(["status" => "success", "message" => __('message.store', ['model' => __('message.model.role')]), "role" => $role], Response::HTTP_CREATED);
    }

    public function update($role)
    {
        return response()->json(["status" => "success", "message" => __('message.update', ['model' => __('message.model.role')]), "role" => $role], Response::HTTP_ACCEPTED);
    }

    public function destroy()
    {
        return response()->json(["status" => "success", "message" => __('message.destroy', ['model' => __('message.model.role')])], Response::HTTP_ACCEPTED);
    }

    public function storeFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.storeFailed', ['model' => __('message.model.role')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function updateFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.updateFailed', ['model' => __('message.model.role')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function destroyFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.destroyFailed', ['model' => __('message.model.role')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
