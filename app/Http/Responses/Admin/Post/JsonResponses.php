<?php
namespace App\Http\Responses\Admin\Post;
use App\Http\Resources\Api\V1\Post\PostWithoutRelationResource;
use Illuminate\Http\Response;
class JsonResponses
{
    public function index($posts)
    {
        return response()->json(["status" => "success", "posts" => PostWithoutRelationResource::collection($posts)], Response::HTTP_OK);
    }
    public function invalidPostId()
    {
        return response()->json(["status" => "error", "message" => __('message.invalidId', ['model' => __('message.model.post')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function show($post)
    {
        return response()->json(["status" => "success", "post" => PostWithoutRelationResource::make($post)], Response::HTTP_OK);
    }
    public function store($post)
    {
        return response()->json(["status" => "success", "message" => __('message.store', ['model' => __('message.model.post')]), "post" => PostWithoutRelationResource::make($post)], Response::HTTP_CREATED);
    }
    public function update($post)
    {
        return response()->json(["status" => "success", "message" => __('message.update', ['model' => __('message.model.post')]), "post" => PostWithoutRelationResource::make($post)], Response::HTTP_ACCEPTED);
    }
    public function destroy()
    {
        return response()->json(["status" => "success", "message" => __('message.destroy', ['model' => __('message.model.post')])], Response::HTTP_ACCEPTED);
    }
    public function storeFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.storeFailed', ['model' => __('message.model.post')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function updateFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.updateFailed', ['model' => __('message.model.post')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function destroyFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.destroyFailed', ['model' => __('message.model.post')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
