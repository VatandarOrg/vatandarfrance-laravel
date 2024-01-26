<?php

namespace App\Services\Permission;

use App\Services\ModelService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Imanghafoori\Helpers\Nullable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService extends ModelService
{

    public function __construct(Permission $permission)
    {
        $this->setModel($permission);
    }

    public static function new()
    {
        return static::make(new Permission());
    }

    public static function make(Permission $permission)
    {
        return new static($permission);
    }

    public function create(array $data = []): ?Nullable
    {
        $this->afterCallback(function (Permission $permission, PermissionService $service) use ($data) {
            if (isset($data['roles'])) {
                $service->syncRoles($data['roles']);
            }
        });

        return parent::create($data);
    }

    public function update($data = []): Nullable
    {
        $this->afterCallback(function (Permission $permission, PermissionService $service) use ($data) {
            if (isset($data['roles'])) {
                $service->syncRoles($data['roles']);
            }
        });

        return parent::update($data);
    }

    public function delete(): ?Nullable
    {
        return parent::delete();
    }

    public function syncRoles(array $roles): bool
    {
        $roles = Collection::make(Arr::wrap($roles));

        $roles = $roles->map(function ($value) {
            if ($value instanceof Role) {
                return $value;
            } else {
                try {
                    return Role::findById($value);
                } catch (\Throwable $th) {
                    return null;
                }
            }
        })->filter(function ($value) {
            return !is_null($value);
        })->map(function ($value) {
            return [
                'role_id' => $value->getKey(),
            ];
        })->keyBy('role_id');

        $this->model->syncRoles($roles);

        return true;
    }
}
