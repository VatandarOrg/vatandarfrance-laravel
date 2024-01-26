<?php

namespace App\Http\Responses\Admin\Role;

class HtmlyResponses
{
    public function index($roles, $permissions)
    {
        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function invalidRoleId()
    {
        return redirect()->back()->with(['danger-custom' => __("نقش مورد نظر یافت نشد."), 'title' => 'عملیات با شکست مواجه شد']);
    }

    public function edit($role, $permissions)
    {
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function store()
    {
        return redirect()->back()->with(['success' => __("نقش با موفقیت ایجاد شد."), 'title' => 'test']);
    }

    public function update()
    {
        return redirect()->route('admin.roles.index')->with(['success' => __("نقش با موفقیت ویرایش شد."), 'title' => 'test']);
    }

    public function destroy()
    {
        return redirect()->back()->with(['success' => __("نقش با موفقیت حذف شد."), 'title' => 'test']);
    }

    public function storeFailed()
    {
        return redirect()->back()->with(['danger-custom' => __("در روند ایجاد نقش مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }

    public function updateFailed()
    {
        return redirect()->back()->with(['danger-custom' => __("در روند ویرایش نقش مشکلی پیش آمده است"), 'title' => 'عملیات با شکست مواجه شد']);
    }

    public function destroyFailed()
    {
        return redirect()->back()->with(['danger-custom' => __("در روند حذف نقش مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
}
