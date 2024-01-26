<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DB\Admin\RolesRepo;
use Spatie\Permission\Models\Role;
use App\Services\Role\RoleService;
use App\Services\Permission\PermissionService;
use App\ProtectionLayers\EnsureRoleIdExists;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;
use App\Http\Responses\Admin\RoleResponse;

class RoleController extends Controller
{
    public function __construct()
    {
        EnsureRoleIdExists::install();

        resolve(StartGuarding::class)->start();
    }

    public function index()
    {
        $roles = RoleService::new()->allWithRelation(['permissions']);

        $permissions = PermissionService::new()->allWithRelation(['roles']);

        return RoleResponse::index($roles, $permissions);
    }

    public function store()
    {
        $this->validateForm(request());

        $role = RoleService::new()
            ->create(request()->only(['name', 'permissions']))
            ->getOrSend([RoleResponse::class, 'storeFailed']);

        return RoleResponse::store($role);
    }

    public function edit($id)
    {
        $role = RoleService::new()->findByIdWithRelation($id, ['permissions']);

        $permissions = PermissionService::new()->allWithRelation(['roles']);

        return RoleResponse::edit($role, $permissions);
    }

    public function update($id)
    {
        HeyMan::checkPoint('EnsureRoleIdExists');

        $this->validateForm(request());
        request()->merge(['permissions' => request()->permissions ?: []]);

        $role = RoleService::make(RoleService::new()->findByIdWithRelation($id))
            ->update(request()->only(['name', 'permissions']))
            ->getOrSend([RoleResponse::class, 'updateFailed']);

        return RoleResponse::update();
    }

    public function destroy($id)
    {
        HeyMan::checkPoint('EnsureRoleIdExists');

        RoleService::make(RoleService::new()->findByIdWithRelation($id))->delete()
            ->getOrSend([RoleResponse::class, 'destroyFailed']);

        return RoleResponse::destroy();
    }

    protected function validateForm($request)
    {
        return $request->validate([
            'name' => 'required|string',
        ]);
    }
}
