<?php
namespace App\Http\Responses\Admin\Slider;
use App\Http\Resources\Api\V1\Slider\SliderWithoutRelationResource;
use Illuminate\Http\Response;
class JsonResponses
{
    public function index($sliders)
    {
        return response()->json(["status" => "success", "sliders" => SliderWithoutRelationResource::collection($sliders)], Response::HTTP_OK);
    }
    public function invalidSliderId()
    {
        return response()->json(["status" => "error", "message" => __('message.invalidId', ['model' => __('message.model.slider')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function show($slider)
    {
        return response()->json(["status" => "success", "slider" => SliderWithoutRelationResource::make($slider)], Response::HTTP_OK);
    }
    public function store($slider)
    {
        return response()->json(["status" => "success", "message" => __('message.store', ['model' => __('message.model.slider')]), "slider" => SliderWithoutRelationResource::make($slider)], Response::HTTP_CREATED);
    }
    public function update($slider)
    {
        return response()->json(["status" => "success", "message" => __('message.update', ['model' => __('message.model.slider')]), "slider" => SliderWithoutRelationResource::make($slider)], Response::HTTP_ACCEPTED);
    }
    public function destroy()
    {
        return response()->json(["status" => "success", "message" => __('message.destroy', ['model' => __('message.model.slider')])], Response::HTTP_ACCEPTED);
    }
    public function storeFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.storeFailed', ['model' => __('message.model.slider')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function updateFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.updateFailed', ['model' => __('message.model.slider')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function destroyFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.destroyFailed', ['model' => __('message.model.slider')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
