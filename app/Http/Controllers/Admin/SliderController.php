<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\Admin\SliderResponse;
use App\Models\Slider;
use App\ProtectionLayers\EnsureSliderIdExists;
use App\Services\Slider\SliderService;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;

class SliderController extends Controller
{
    public function __construct()
    {
        EnsureSliderIdExists::install();
        resolve(StartGuarding::class)->start();
    }
    public function index()
    {
        request()->pagination = 10;

        $sliders = SliderService::new()->allWithRelation();
        return SliderResponse::index($sliders);
    }
    public function store()
    {
        $this->validateStoreForm(request());
        $inputs = request()->only([
            'name', 'web_view', 'link', 'lang', 'priority'
        ]);
        $slider = SliderService::new()
            ->create($inputs)
            ->getOrSend([SliderResponse::class, 'storeFailed']);
        $slider->addMediaFromRequest('image')->toMediaCollection();
        return SliderResponse::store($slider);
    }
    public function edit($id)
    {
        HeyMan::checkPoint('EnsureSliderIdExists');
        $slider = SliderService::new()->findByIdWithRelation($id);
        return SliderResponse::edit($slider);
    }
    public function update($id)
    {
        HeyMan::checkPoint('EnsureSliderIdExists');
        $this->validateUpdateForm(request());
        $inputs = request()->only([
            'name', 'web_view', 'link', 'lang', 'priority'
        ]);
        $slider = SliderService::make(SliderService::new()
            ->findByIdWithRelation($id))
            ->update($inputs)
            ->getOrSend([SliderResponse::class, 'updateFailed']);
        if (request()->hasFile('image')) {
            $slider->clearMediaCollection();
            $slider->addMediaFromRequest('image')->toMediaCollection();
        }
        return SliderResponse::update($slider);
    }
    public function destroy($id)
    {
        HeyMan::checkPoint('EnsureSliderIdExists');
        SliderService::make(SliderService::new()->findByIdWithRelation($id))->delete()
            ->getOrSend([SliderResponse::class, 'destroyFailed']);
        return SliderResponse::destroy();
    }
    protected function validateStoreForm($request)
    {
        return $request->validate([
            'name' => ['nullable', 'string', 'min:3'],
            'web_view' => ['required', 'boolean'],
            'link' => ['required_if:web_view,true', 'nullable', 'string', 'url'],
            'lang' => ['required', 'string'],
            'image' => ['required', 'file'],
            'priority' => ['required', 'integer']
        ]);
    }

    protected function validateUpdateForm($request)
    {
        return $request->validate([
            'name' => ['nullable', 'string', 'min:3'],
            'web_view' => ['required', 'boolean'],
            'link' => ['required_if:web_view,true', 'nullable', 'string', 'url'],
            'lang' => ['required', 'string'],
            'image' => ['nullable', 'file'],
            'priority' => ['required', 'integer']
        ]);
    }
}
