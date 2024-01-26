<?php
namespace App\Http\Responses\Admin\Section;
use App\Http\Resources\Api\V1\Section\SectionWithoutRelationResource;
use Illuminate\Http\Response;
class JsonResponses
{
    public function index($sections)
    {
        return response()->json(["status" => "success", "sections" => SectionWithoutRelationResource::collection($sections)], Response::HTTP_OK);
    }
    public function invalidSectionId()
    {
        return response()->json(["status" => "error", "message" => __('message.invalidId', ['model' => __('message.model.section')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function show($section)
    {
        return response()->json(["status" => "success", "section" => SectionWithoutRelationResource::make($section)], Response::HTTP_OK);
    }
    public function store($section)
    {
        return response()->json(["status" => "success", "message" => __('message.store', ['model' => __('message.model.section')]), "section" => SectionWithoutRelationResource::make($section)], Response::HTTP_CREATED);
    }
    public function update($section)
    {
        return response()->json(["status" => "success", "message" => __('message.update', ['model' => __('message.model.section')]), "section" => SectionWithoutRelationResource::make($section)], Response::HTTP_ACCEPTED);
    }
    public function destroy()
    {
        return response()->json(["status" => "success", "message" => __('message.destroy', ['model' => __('message.model.section')])], Response::HTTP_ACCEPTED);
    }
    public function storeFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.storeFailed', ['model' => __('message.model.section')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function updateFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.updateFailed', ['model' => __('message.model.section')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function destroyFailed()
    {
        return response()->json(["status" => "error", "message" => __('message.destroyFailed', ['model' => __('message.model.section')])], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
