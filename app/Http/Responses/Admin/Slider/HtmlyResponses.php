<?php

namespace App\Http\Responses\Admin\Slider;

class HtmlyResponses
{
    public function index($sliders)
    {
        return view('admin.sliders.index', compact('sliders'));
    }
    public function invalidSliderId()
    {
        return redirect()->back()->with(['danger' => __("Slider مورد نظر یافت نشد."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function create()
    {
        return view('admin.sliders.create');
    }
    public function edit($slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }
    public function store($slider)
    {
        return redirect()->route('admin.sliders.index')->with(['success' => __("اسلایدر با موفقیت ایجاد شد."), 'title' => 'test']);
    }
    public function update($slider)
    {
        return redirect()->route('admin.sliders.index')->with(['success' => __("اسلایدر با موفقیت ویرایش شد."), 'title' => 'test']);
    }
    public function destroy()
    {
        return redirect()->back()->with(['success' => __("اسلایدر با موفقیت حذف شد."), 'title' => 'test']);
    }
    public function storeFailed()
    {
        return redirect()->back()->with(['danger' => __("در روند ایجاد اسلایدر مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function updateFailed()
    {
        return redirect()->back()->with(['danger' => __("در روند ویرایش اسلایدر مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function destroyFailed()
    {
        return redirect()->back()->with(['danger' => __("در روند حذف اسلایدر مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
}
