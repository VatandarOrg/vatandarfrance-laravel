<?php

namespace App\Http\Responses\Admin\Permission;

class HtmlyResponses
{
    public function index($permissions, $roles)
    {
        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    public function invalidPermissionId()
    {
        return redirect()->back()->with(['danger-custom' => __("دسترسی مورد نظر یافت نشد."), 'title' => 'عملیات با شکست مواجه شد']);
    }

    public function edit($permission, $roles)
    {
        return view('admin.permissions.edit', compact('permission', 'roles'));
    }

    public function store()
    {
        return redirect()->back()->with(['success' => __("دسترسی با موفقیت ایجاد شد."), 'title' => 'test']);
    }

    public function update()
    {
        return redirect()->route('admin.permissions.index')->with(['success' => __("دسترسی با موفقیت ویرایش شد."), 'title' => 'test']);
    }

    public function destroy()
    {
        return redirect()->back()->with(['success' => __("نقش با موفقیت حذف شد."), 'title' => 'test']);
    }

    public function storeFailed()
    {
        return redirect()->back()->with(['danger-custom' => __("در روند ایجاد دسترسی مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }

    public function updateFailed()
    {
        return redirect()->back()->with(['danger-custom' => __("در روند ویرایش دسترسی مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }

    public function destroyFailed()
    {
        return redirect()->back()->with(['danger-custom' => __("در روند حذف نقش مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
}
