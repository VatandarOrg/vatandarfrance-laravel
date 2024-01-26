<?php

namespace App\Http\Responses\Admin\File;

class HtmlyResponses
{
    public function index($files)
    {
        return view('admin.files.index', compact('files'));
    }

    public function store($file)
    {
        return redirect()->back()->withSuccess('File has uploaded successfully');
    }

    public function storeFailed($message)
    {
        return redirect()->back()->withError($message);
    }
    public function destroy()
    {
        return back();
    }
}
