<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses\Admin\PermissionResponse;
use App\ProtectionLayers\EnsurePermissionIdExists;
use App\Services\Permission\PermissionService;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;
use App\Services\Role\RoleService;

class PermissionController extends Controller
{
    public function __construct()
    {
        EnsurePermissionIdExists::install();

        resolve(StartGuarding::class)->start();
    }

    public function index()
    {
        $permissions = PermissionService::new()->allWithRelationAndPaginate(['roles'], 10);

        $roles = RoleService::new()->allWithRelation(['permissions']);

        return PermissionResponse::index($permissions, $roles);
    }

    static function edit($id)
    {
        $roles = RoleService::new()->allWithRelation(['permissions']);

        $permission = PermissionService::new()->findByIdWithRelation($id);

        return PermissionResponse::edit($permission, $roles);
    }

    public function update($id)
    {
        HeyMan::checkPoint('EnsurePermissionIdExists');

        $this->validateForm(request());
        request()->merge(['roles' => request()->roles ?: []]);

        $permission = PermissionService::make(PermissionService::new()->findByIdWithRelation($id))
            ->update(request()->only(['name', 'roles']))
            ->getOrSend([PermissionResponse::class, 'updateFailed']);

        return PermissionResponse::update($permission);
    }

    public function store()
    {
        $this->validateForm(request());

        $permission = PermissionService::new()
            ->create(request()->only(['name', 'roles']))
            ->getOrSend([PermissionResponse::class, 'storeFailed']);

        return PermissionResponse::store($permission);
    }

    public function destroy($id)
    {
        HeyMan::checkPoint('EnsurePermissionIdExists');

        PermissionService::make(PermissionService::new()->findByIdWithRelation($id))->delete()
            ->getOrSend([PermissionResponse::class, 'destroyFailed']);

        return PermissionResponse::destroy();
    }

    protected function validateForm($request)
    {
        return $request->validate([
            'name' => 'required|string',
        ]);
    }
}
