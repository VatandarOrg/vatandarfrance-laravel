<?php

namespace App\Services\User;

use App\Http\Resources\Api\V1\User\UserListResource;
use App\Models\Hobby;
use App\Models\Recommend;
use App\Models\Sport;
use App\Models\User;
use App\Services\File\FileService;
use App\Services\ModelService;
use App\Services\Profile\ProfileService;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Support\Arr;
use Imanghafoori\Helpers\Nullable;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class UserService extends ModelService
{

    public function __construct(User $user)
    {
        $this->setModel($user);
    }

    public static function new($status = null)
    {
        return static::make(new User(), $status);
    }

    public static function make(User $user, $status = null)
    {
        return new static($user, $status);
    }

    public function create(array $data = []): ?Nullable
    {
        $this->afterCallback(function (User $user, UserService $service) use ($data) {
            if (isset($data['role_id'])) {
                // $service->syncRoles($data['role_id']);
            }
        });

        return parent::create($data);
    }

    public function update($data = []): Nullable
    {
        return parent::update($data);
    }

    public function delete(): ?Nullable
    {
        return parent::delete();
    }

    public function findByUsername($username)
    {
        return $this->model->query()->where('mobile', $username)->orWhere('email', $username)->first();
    }

    public function findByMobile($mobile)
    {
        return $this->model->query()->firstWhere('mobile', $mobile);
    }

    public function findByEmail($email)
    {
        return $this->model->query()->firstWhere('email', $email);
    }

    public function syncRoles(array $roles): bool
    {
        $roles = Collection::make(Arr::wrap($roles));

        $roles = $roles->map(function ($value) {
            if ($value instanceof Role) {
                return $value;
            } else {
                try {
                    return Role::findByName($value);
                } catch (\Throwable $th) {
                    return null;
                }
            }
        });

        $this->model->syncRoles($roles);

        return true;
    }

    public function syncPermissions(array $permissions): bool
    {
        $permissions = Collection::make(Arr::wrap($permissions));

        $permissions = $permissions->map(function ($value) {
            if ($value instanceof Permission) {
                return $value;
            } else {
                try {
                    return Permission::findByName($value);
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
