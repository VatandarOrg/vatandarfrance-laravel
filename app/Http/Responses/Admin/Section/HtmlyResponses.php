<?php

namespace App\Http\Responses\Admin\Section;

class HtmlyResponses
{
    public function index($sections)
    {
        return view('admin.sections.index', compact('sections'));
    }
    public function invalidSectionId()
    {
        return redirect()->back()->with(['danger' => __("سکشن مورد نظر یافت نشد."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function create()
    {
        return view('admin.sections.create');
    }
    public function edit($section)
    {
        return view('admin.sections.edit', compact('section'));
    }
    public function store($section)
    {
        return redirect()->route('admin.sections.index')->with(['success' => __("سکشن با موفقیت ایجاد شد."), 'title' => 'test']);
    }
    public function update($section)
    {
        return redirect()->route('admin.sections.index')->with(['success' => __("سکشن با موفقیت ویرایش شد."), 'title' => 'test']);
    }
    public function destroy()
    {
        return redirect()->back()->with(['success' => __("سکشن با موفقیت حذف شد."), 'title' => 'test']);
    }
    public function storeFailed()
    {
        return redirect()->back()->with(['danger' => __("در روند ایجاد سکشن مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function updateFailed()
    {
        return redirect()->back()->with(['danger' => __("در روند ویرایش سکشن مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function destroyFailed()
    {
        return redirect()->back()->with(['danger' => __("در روند حذف سکشن مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
}
