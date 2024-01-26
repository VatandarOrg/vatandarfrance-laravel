<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\Admin\SectionResponse;
use App\Models\Section;
use App\ProtectionLayers\EnsureSectionIdExists;
use App\Services\Section\SectionService;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;

class SectionController extends Controller
{
    public function __construct()
    {
        EnsureSectionIdExists::install();
        resolve(StartGuarding::class)->start();
    }
    public function index()
    {
        $sections = SectionService::new()->allWithRelation();
        return SectionResponse::index($sections);
    }
    public function store()
    {
        $this->validateStoreForm(request());
        $inputs = request()->only([
            'name', 'priority'
        ]);
        $section = SectionService::new()
            ->create($inputs)
            ->getOrSend([SectionResponse::class, 'storeFailed']);
        return SectionResponse::store($section);
    }
    public function edit($id)
    {
        HeyMan::checkPoint('EnsureSectionIdExists');
        $section = SectionService::new()->findByIdWithRelation($id);
        return SectionResponse::edit($section);
    }
    public function update($id)
    {
        HeyMan::checkPoint('EnsureSectionIdExists');
        $this->validateStoreForm(request());
        $inputs = request()->only([
            'name', 'priority'
        ]);
        $section = SectionService::make(SectionService::new()
            ->findByIdWithRelation($id))
            ->update($inputs)
            ->getOrSend([SectionResponse::class, 'updateFailed']);
        return SectionResponse::update($section);
    }
    public function destroy($id)
    {
        HeyMan::checkPoint('EnsureSectionIdExists');
        SectionService::make(SectionService::new()->findByIdWithRelation($id))->delete()
            ->getOrSend([SectionResponse::class, 'destroyFailed']);
        return SectionResponse::destroy();
    }
    protected function validateStoreForm($request)
    {
        return $request->validate([
            'name' => ['nullable', 'string', 'min:3'],
            'priority' => ['required', 'integer']
        ]);
    }
}
