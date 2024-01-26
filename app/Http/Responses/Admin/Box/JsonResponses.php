<?php
namespace App\Http\Responses\Admin\Box;
use App\Http\Resources\Api\V1\Box\BoxWithoutRelationResource;
use Illuminate\Http\Response;
class JsonResponses
{
    public function index($boxes)
    {
        return response()->json(["status" => "success", "boxes" => BoxWithoutRelationResource::collection($boxes)], Response::HTTP_OK);
    }
    public function invalidBoxId()
    {
        return response()->json(["status" => "error", "message" => __('message.invalidId', ['model' => __('message.model.box')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function show($box)
    {
        return response()->json(["status" => "success", "box" => BoxWithoutRelationResource::make($box)], Response::HTTP_OK);
    }
    public function store($box)
    {
        return response()->json(["status" => "success", "message" => __('message.store', ['model' => __('message.model.box')]), "box" => BoxWithoutRelationResource::make($box)], Response::HTTP_CREATED);
    }
    public function update($box)
    {
        return response()->json(["status" => "success", "message" => __('message.update', ['model' => __('message.model.box')]), "box" => BoxWithoutRelationResource::make($box)], Response::HTTP_ACCEPTED);
    }
    public function destroy()
    {
        return response()->json(["status" => "success", "message" => __('message.destroy', ['model' => __('message.model.box')])], Response::HTTP_ACCEPTED);
    }
    public function storeFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.storeFailed', ['model' => __('message.model.box')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function updateFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.updateFailed', ['model' => __('message.model.box')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function destroyFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.destroyFailed', ['model' => __('message.model.box')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
