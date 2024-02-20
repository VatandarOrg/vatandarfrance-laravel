<?php

namespace App\Http\Responses\Admin\Post;

class HtmlyResponses
{
    public function index($posts, $sections)
    {
        return view('admin.posts.index', compact('posts', 'sections'));
    }
    public function invalidPostId()
    {
        return redirect()->back()->with(['danger' => __("Post مورد نظر یافت نشد."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function create()
    {
        return view('admin.posts.create');
    }
    public function edit($post, $sections)
    {
        return view('admin.posts.edit', compact('post', 'sections'));
    }
    public function store($post)
    {
        return redirect()->route('admin.posts.index')->with(['success' => __("Post با موفقیت ایجاد شد."), 'title' => 'test']);
    }
    public function update($post)
    {
        return redirect()->route('admin.posts.index')->with(['success' => __("Post با موفقیت ویرایش شد."), 'title' => 'test']);
    }
    public function destroy()
    {
        return redirect()->back()->with(['success' => __("Post با موفقیت حذف شد."), 'title' => 'test']);
    }
    public function storeFailed()
    {
        return redirect()->back()->with(['danger' => __("در روند ایجاد Post مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function updateFailed()
    {
        return redirect()->back()->with(['danger' => __("در روند ویرایش Post مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function destroyFailed()
    {
        return redirect()->back()->with(['danger' => __("در روند حذف Post مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
}
