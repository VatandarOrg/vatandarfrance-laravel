<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\Admin\BoxResponse;
use App\Models\Box;
use App\ProtectionLayers\EnsureBoxIdExists;
use App\Services\Box\BoxService;
use App\Services\Section\SectionService;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;

class BoxController extends Controller
{
    public function __construct()
    {
        EnsureBoxIdExists::install();
        resolve(StartGuarding::class)->start();
    }

    public function index()
    {
        $boxes = BoxService::new()->allWithRelation();
        $sections = SectionService::new()->allWithRelation();

        return BoxResponse::index($boxes, $sections);
    }

    public function store()
    {
        $this->validateStoreForm(request());
        $inputs = request()->only([
            'name', 'web_view', 'link', 'lang', 'priority', 'section_id', 'color'
        ]);
        $box = BoxService::new()
            ->afterCallback(function (Box $box, BoxService $service) {
                $box->addMediaFromRequest('image')->toMediaCollection();
            })
            ->create($inputs)
            ->getOrSend([BoxResponse::class, 'storeFailed']);
        return BoxResponse::store($box);
    }

    public function edit($id)
    {
        HeyMan::checkPoint('EnsureBoxIdExists');
        $box = BoxService::new()->findByIdWithRelation($id);
        $sections = SectionService::new()->allWithRelation();

        return BoxResponse::edit($box, $sections);
    }

    public function update($id)
    {
        HeyMan::checkPoint('EnsureBoxIdExists');
        $this->validateStoreForm(request());
        $inputs = request()->only([
            'name', 'web_view', 'link', 'lang', 'priority', 'section_id', 'color'
        ]);
        $box = BoxService::make(BoxService::new()
            ->findByIdWithRelation($id))
            ->afterCallback(function (Box $box, BoxService $service) {
                if (request()->hasFile('image')) {
                    $box->clearMediaCollection();
                    $box->addMediaFromRequest('image')->toMediaCollection();
                }
            })
            ->update($inputs)
            ->getOrSend([BoxResponse::class, 'updateFailed']);
        return BoxResponse::update($box);
    }

    public function destroy($id)
    {
        HeyMan::checkPoint('EnsureBoxIdExists');
        BoxService::make(BoxService::new()->findByIdWithRelation($id))->delete()
            ->getOrSend([BoxResponse::class, 'destroyFailed']);
        return BoxResponse::destroy();
    }

    protected function validateStoreForm($request)
    {
        return $request->validate([
            'name' => ['nullable', 'string', 'min:3'],
            'web_view' => ['required', 'boolean'],
            'link' => ['required_if:web_view,true', 'nullable', 'string', 'url'],
            'lang' => ['required', 'string'],
            'image' => ['file'],
            'priority' => ['required', 'integer'],
            'color' => ['nullable', 'string', 'hex_color'],
            'section_id' => ['required', 'integer', 'exists:sections,id'],
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
            'priority' => ['required', 'integer'],
            'color' => ['nullable', 'string', 'hex_color'],
            'section_id' => ['required', 'integer', 'exists:sections,id'],
        ]);
    }
}
