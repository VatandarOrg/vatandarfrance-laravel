<?php

namespace App\Http\Responses\Admin\Box;

class HtmlyResponses
{
    public function index($boxes, $sections)
    {
        return view('admin.boxes.index', compact('boxes', 'sections'));
    }
    public function invalidBoxId()
    {
        return redirect()->back()->with(['danger' => __("باکس مورد نظر یافت نشد."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function create()
    {
        return view('admin.boxes.create');
    }
    public function edit($box, $sections)
    {
        return view('admin.boxes.edit', compact('box', 'sections'));
    }
    public function store($box)
    {
        return redirect()->route('admin.boxes.index')->with(['success' => __("باکس با موفقیت ایجاد شد."), 'title' => 'test']);
    }
    public function update($box)
    {
        return redirect()->route('admin.boxes.index')->with(['success' => __("باکس با موفقیت ویرایش شد."), 'title' => 'test']);
    }
    public function destroy()
    {
        return redirect()->back()->with(['success' => __("باکس با موفقیت حذف شد."), 'title' => 'test']);
    }
    public function storeFailed()
    {
        return redirect()->back()->with(['danger' => __("در روند ایجاد باکس مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function updateFailed()
    {
        return redirect()->back()->with(['danger' => __("در روند ویرایش باکس مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function destroyFailed()
    {
        return redirect()->back()->with(['danger' => __("در روند حذف باکس مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
}
