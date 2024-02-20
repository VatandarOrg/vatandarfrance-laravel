<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\Admin\PostResponse;
use App\Models\Post;
use App\ProtectionLayers\EnsurePostIdExists;
use App\Services\Post\PostService;
use App\Services\Section\SectionService;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;

class PostController extends Controller
{
    public function __construct()
    {
        EnsurePostIdExists::install();
        resolve(StartGuarding::class)->start();
    }
    public function index()
    {
        $posts = PostService::new()->allWithRelation();
        $sections = SectionService::new()->allWithRelation();

        return PostResponse::index($posts, $sections);
    }
    public function store()
    {
        $this->validateStoreForm(request());
        $inputs = request()->only([
            'title', 'description', 'web_view', 'link', 'lang', 'priority', 'section_id'
        ]) + ['user_id' => auth()->id()];
        $post = PostService::new()
            ->afterCallback(function (Post $post, PostService $service) {
                $post->addMediaFromRequest('image')->toMediaCollection();
            })
            ->create($inputs)
            ->getOrSend([PostResponse::class, 'storeFailed']);
        return PostResponse::store($post);
    }

    public function show($id)
    {
        HeyMan::checkPoint('EnsurePostIdExists');
        $post = PostService::new()->findByIdWithRelation($id);
        return PostResponse::show($post);
    }

    public function edit($id)
    {
        HeyMan::checkPoint('EnsurePostIdExists');
        $box = PostService::new()->findByIdWithRelation($id);
        $sections = SectionService::new()->allWithRelation();

        return PostResponse::edit($box, $sections);
    }

    public function update($id)
    {
        HeyMan::checkPoint('EnsurePostIdExists');
        $this->validateStoreForm(request());
        $inputs = request()->only([
            'title', 'description', 'web_view', 'link', 'lang', 'priority', 'section_id'
        ]);
        $post = PostService::make(PostService::new()
            ->findByIdWithRelation($id))
            ->afterCallback(function (Post $post, PostService $service) {
                if (request()->hasFile('image')) {
                    $post->clearMediaCollection();
                    $post->addMediaFromRequest('image')->toMediaCollection();
                }
            })
            ->update($inputs)
            ->getOrSend([PostResponse::class, 'updateFailed']);
        return PostResponse::update($post);
    }

    public function destroy($id)
    {
        HeyMan::checkPoint('EnsurePostIdExists');
        PostService::make(PostService::new()->findByIdWithRelation($id))->delete()
            ->getOrSend([PostResponse::class, 'destroyFailed']);
        return PostResponse::destroy();
    }

    protected function validateStoreForm($request)
    {
        return $request->validate([
            'section_id' => ['required', 'integer', 'exists:sections,id'],
            'image' => 'required|file|mimetypes:image/jpeg,image/png',
            'title' => ['nullable', 'string', 'min:3'],
            'description' => ['nullable', 'string', 'min:3'],
            'web_view' => ['required', 'boolean'],
            'link' => ['nullable', 'string', 'min:3'],
            'lang' => ['required', 'string'],
            'priority' => ['required', 'integer'],
        ]);
    }

    protected function validateUpdateForm($request)
    {
        return $request->validate([
            'section_id' => ['required', 'integer', 'exists:sections,id'],
            'image' => 'nullable|file|mimetypes:image/jpeg,image/png',
            'title' => ['nullable', 'string', 'min:3'],
            'description' => ['nullable', 'string', 'min:3'],
            'web_view' => ['required', 'boolean'],
            'link' => ['nullable', 'string', 'min:3'],
            'lang' => ['required', 'string'],
            'priority' => ['required', 'integer'],
        ]);
    }
}
