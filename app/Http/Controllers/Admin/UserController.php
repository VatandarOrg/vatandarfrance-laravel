<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\Admin\UserResponse;
use App\Models\User;
use App\ProtectionLayers\EnsureUserCanBuySubscription;
use App\ProtectionLayers\EnsureUserIdExists;
use App\Services\Permission\PermissionService;
use App\Services\Role\RoleService;
use App\Services\Subscription\SubscriptionService;
use App\Services\User\UserService;
use Illuminate\Http\Response;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use Illuminate\Validation\Rule;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;

class UserController extends Controller
{
    public function __construct()
    {
        EnsureUserIdExists::install();
        EnsureUserCanBuySubscription::install();

        resolve(StartGuarding::class)->start();
    }
    public function index()
    {
        request()->pagination = 10;

        $users = UserService::new()->allWithRelationAndPaginate([], 10);

        return UserResponse::index($users);
    }
    public function create()
    {
        $roles = RoleService::new()->allWithRelation();
        $permissions = PermissionService::new()->allWithRelation();

        return UserResponse::create($roles, $permissions);
    }
    public function store()
    {
        $this->validateStoreForm(request());
        $inputs = request()->only(['first_name', 'last_name', 'email', 'mobile', 'permissions', 'roles']) + ['password' => Hash::make(request()->password), 'mobile_verified_at' => request()->mobile ? now() : null, 'email_verified_at' => request()->email ? now() : null];
        $user = UserService::new()
            ->afterCallback(function (User $user, UserService $service) {
                $service->syncRoles(request()->roles ?? []);
                $service->syncPermissions(request()->permissions ?? []);
            })
            ->create($inputs)
            ->getOrSend([UserResponse::class, 'storeFailed']);
        return UserResponse::store($user);
    }
    public function show($id)
    {
        HeyMan::checkPoint('EnsureUserIdExists');
        $user = UserService::new()->findByIdWithRelation($id);

        return UserResponse::show($user);
    }
    public function edit($id)
    {
        HeyMan::checkPoint('EnsureUserIdExists');
        $user = UserService::new()->findByIdWithRelation($id);
        $roles = RoleService::new()->allWithRelation();
        $permissions = PermissionService::new()->allWithRelation();

        return UserResponse::edit($user, $roles, $permissions);
    }
    public function update($id)
    {
        HeyMan::checkPoint('EnsureUserIdExists');
        $this->validateUpdateForm(request(), $id);
        $inputs = request()->only(['first_name', 'last_name', 'email', 'mobile', 'permissions', 'roles']);
        $user = UserService::make(UserService::new()->findByIdWithRelation($id))
            ->afterCallback(function (User $user, UserService $service) {
                $service->syncRoles(request()->roles ?? []);
                $service->syncPermissions(request()->permissions ?? []);
            })
            ->update($inputs)
            ->getOrSend([UserResponse::class, 'updateFailed']);
        return UserResponse::update($user);
    }
    public function destroy($id)
    {
        HeyMan::checkPoint('EnsureUserIdExists');
        UserService::make(UserService::new()->findByIdWithRelation($id))->delete()
            ->getOrSend([UserResponse::class, 'destroyFailed']);
        return UserResponse::destroy();
    }
    protected function validateStoreForm($request)
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required_if:mobile,null', 'nullable', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password, 'confirmed'],
            'mobile' => ['required_if:email,null', 'nullable', 'numeric', new ValidPhoneNumber, 'unique:users,mobile'],
        ]);
    }
    protected function validateUpdateForm($request, $id)
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required_if:mobile,null', 'nullable', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'mobile' => [
                'required_if:email,null', 'nullable', 'numeric', new ValidPhoneNumber,
                Rule::unique('users')->ignore($id),
            ],
        ]);
    }

    public function addSubscription($id)
    {
        HeyMan::checkPoint('EnsureUserIdExists');
        $user = UserService::new()->findByIdWithRelation($id);
        if ($user->subscription) {
            return redirect()->back()->with(['danger-custom' => "کاربر مورد نظر اشتراک دارد."]);
        }
        SubscriptionService::new()->create(['user_id' => $user->id, 'expired_at' => request()->expired_at])->getOrSend(function () {
            return redirect()->back()->with(['danger-custom' => "در روند ایجاد اشتراک برای کاربر مشکلی بوجود آمده."]);
        });
        return redirect()->back()->with(['success-custom' => "اشتراک کاربر با موفقیت ایجاد شد."]);
    }

    public function deleteSubscription($id)
    {
        HeyMan::checkPoint('EnsureUserIdExists');

        $user = UserService::new()->findByIdWithRelation($id);

        if (!$user->subscription) {
            return redirect()->back()->with(['danger-custom' => "کاربر مورد نظر اشتراک ندارد."]);
        }

        SubscriptionService::make($user->subscription)->delete();

        return redirect()->back()->with(['success-custom' => "اشتراک کاربر با موفقیت حذف شد."]);
    }
}
