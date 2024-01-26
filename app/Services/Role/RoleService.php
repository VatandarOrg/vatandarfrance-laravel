<?php

namespace App\Services\Role;

use App\Services\ModelService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Imanghafoori\Helpers\Nullable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService extends ModelService
{

    public function __construct(Role $role)
    {
        $this->setModel($role);
    }

    public static function new()
    {
        return static::make(new Role());
    }

    public static function make(Role $role)
    {
        return new static($role);
    }

    public function create(array $data = []): ?Nullable
    {
        $this->afterCallback(function (Role $role, RoleService $service) use ($data) {
            if (isset($data['permissions'])) {
                $service->syncPermissions($data['permissions']);
            }
        });

        return parent::create($data);
    }

    public function update($data = []): Nullable
    {
        $this->afterCallback(function (Role $role, RoleService $service) use ($data) {
            if (isset($data['permissions'])) {
                $service->syncPermissions($data['permissions']);
            }
        });

        return parent::update($data);
    }

    public function delete(): ?Nullable
    {
        return parent::delete();
    }

    public function syncPermissions(array $permissions): bool
    {
        $permissions = Collection::make(Arr::wrap($permissions));

        $permissions = $permissions->map(function ($value) {
            if ($value instanceof Permission) {
                return $value;
            } else {
                try {
                    return Permission::findById($value);
                } catch (\Throwable $th) {
                    return null;
                }
            }
        })->filter(function ($value) {
            return !is_null($value);
        })->map(function ($value) {
            return [
                'permission_id' => $value->getKey(),
            ];
        })->keyBy('permission_id');

        $this->model->syncPermissions($permissions);

        return true;
    }
}
