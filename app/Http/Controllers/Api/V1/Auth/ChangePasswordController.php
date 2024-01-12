<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\Auth\AuthenticatedResponse;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ChangePasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validateForm($request);

        $user = auth()->user();

        if (! Hash::check(request()->old_password, $user->password)) {
            return AuthenticatedResponse::changePasswordFailed();
        }

        $user = UserService::make($user)
            ->update(['password' => Hash::make(request()->password)])
            ->getOrSend([AuthenticatedResponse::class, 'changePasswordFailed']);

        return AuthenticatedResponse::changePassword();
    }

    protected function validateForm($request)
    {
        return $request->validate([
            'old_password' => ['required', Rules\Password::defaults()],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }
}
