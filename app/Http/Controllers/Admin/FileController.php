<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\Admin\FileResponse;
use App\ProtectionLayers\EnsureFileIdExists;
use App\Services\File\FileService;
use App\Services\Uploader\Uploader;
use Illuminate\Http\Request;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;

class FileController extends Controller
{

    /**
     * @var Uploader
     */
    private $uploader;
    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;

        EnsureFileIdExists::install();

        resolve(StartGuarding::class)->start();
    }

    public function index()
    {
        $files = FileService::new()->allWithRelationAndPaginate([], 10);

        return FileResponse::index($files);
    }

    public function download($id)
    {
        HeyMan::checkPoint('EnsureFileIdExists');

        return FileService::new()->findByIdWithRelation($id)->download();
    }

    public function destroy($id)
    {
        HeyMan::checkPoint('EnsureFileIdExists');

        FileService::new()->findByIdWithRelation($id)->delete();

        return FileResponse::destroy();
    }

    public function store(Request $request)
    {
        try {
            $this->validateFile($request);

            $file = $this->uploader->upload();

            return FileResponse::store($file);
        } catch (\Exception $e) {
            return FileResponse::storeFailed($e->getMessage());
        }
    }

    private function validateFile($request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimetypes:image/jpeg,image/png,image/svg+xml,video/mp4,application/zip,audio/webm']
        ]);
    }
}
