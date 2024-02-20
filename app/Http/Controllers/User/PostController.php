<?php
namespace App\Http\Controllers\User;
use App\Http\Responses\User\PostResponse;
use App\ProtectionLayers\EnsurePostIdExists;
use App\ProtectionLayers\PreventTamperingOtherPost;
use App\Services\Post\PostService;
use App\Http\Controllers\Controller;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;
class PostController extends Controller
{
    public function __construct()
    {
        EnsurePostIdExists::install();
        PreventTamperingOtherPost::install();
        resolve(StartGuarding::class)->start();
    }
    public function index()
    {
        $posts = PostService::new ()->allWithRelation();
        return PostResponse::index($posts);
    }
    public function store()
    {
        $this->validateStoreForm(request());
        $inputs = request()->only();
        $post = PostService::new ()
            ->create($inputs)
            ->getOrSend([PostResponse::class, 'storeFailed']);
        return PostResponse::store($post);
    }
    public function show($id)
    {
        HeyMan::checkPoint('EnsurePostIdExists');
        HeyMan::checkPoint('PreventTamperingOtherPost');
        $post = PostService::new ()->findByIdWithRelation($id);
        return PostResponse::show($post);
    }
    public function update($id)
    {
        HeyMan::checkPoint('EnsurePostIdExists');
        HeyMan::checkPoint('PreventTamperingOtherPost');
        $this->validateStoreForm(request());
        $inputs = request()->only();
        $post = PostService::make(PostService::new ()->findByIdWithRelation($id))
            ->update($inputs)
            ->getOrSend([PostResponse::class, 'updateFailed']);
        return PostResponse::update($post);
    }
    public function destroy($id)
    {
        HeyMan::checkPoint('EnsurePostIdExists');
        HeyMan::checkPoint('PreventTamperingOtherPost');
        PostService::make(PostService::new ()->findByIdWithRelation($id))->delete()
            ->getOrSend([PostResponse::class, 'destroyFailed']);
        return PostResponse::destroy();
    }
    protected function validateStoreForm($request)
    {
        return $request->validate([
        ]);
    }
}
