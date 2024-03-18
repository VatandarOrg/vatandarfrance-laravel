<?php

namespace App\Http\Responses\Admin\User;

class HtmlyResponses
{
    public function index($users)
    {
        return view('admin.users.index', compact('users'));
    }
    public function invalidUserId()
    {
        return redirect()->back()->with(['danger-custom' => __("کاربر مورد نظر یافت نشد."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function create($roles, $permissions)
    {
        return view('admin.users.create', compact('roles', 'permissions'));
    }
    public function show($user)
    {
        return view('admin.users.show', compact('user'));
    }
    public function edit($user, $roles, $permissions)
    {
        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }
    public function store($user)
    {
        return redirect()->route('admin.users.index')->with(['success' => __("کاربر با موفقیت ایجاد شد."), 'title' => 'test']);
    }
    public function update($user)
    {
        return redirect()->route('admin.users.index')->with(['success' => __("کاربر با موفقیت ویرایش شد."), 'title' => 'test']);
    }
    public function destroy()
    {
        return redirect()->back()->with(['success' => __("کاربر با موفقیت حذف شد."), 'title' => 'test']);
    }
    public function storeFailed()
    {
        return redirect()->back()->with(['danger-custom' => __("در روند ایجاد کاربر مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function updateFailed()
    {
        return redirect()->back()->with(['danger-custom' => __("در روند ویرایش کاربر مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
    public function destroyFailed()
    {
        return redirect()->back()->with(['danger-custom' => __("در روند حذف کاربر مشکلی پیش آمده است."), 'title' => 'عملیات با شکست مواجه شد']);
    }
}
