<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\Auth\AuthenticatedResponse;
use App\Services\User\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;
use App\Services\Auth\TwoFactorAuthentication;
use App\Models\TwoFactor;
use App\Models\User;

class RegisterController extends Controller
{
    public function __construct(TwoFactorAuthentication $twoFactor)
    {
        User::whereNotNull('mobile')->whereNull('mobile_verified_at')->where('created_at', '<', now()->subSeconds(130))->forceDelete();
        TwoFactor::where('created_at', '<', now()->subSeconds(120))->delete();

        $this->twoFactor = $twoFactor;
    }

    public function __invoke(Request $request)
    {
        $this->validateForm($request);

        $inputs = $request->only('first_name', 'last_name', 'email', 'mobile') + ['password' => Hash::make($request->password), 'email_verified_at' => request()->email ? now() : null];

        event(
            new Registered(
                $user = UserService::new()
                    ->create($inputs)
                    ->getOrSend([AuthenticatedResponse::class, 'registerFailed'])
            )
        );

        if ($user->mobile) {
            $result = $this->twoFactor->requestCode($user);
            return ($result == TwoFactorAuthentication::CODE_SENT) ? AuthenticatedResponse::store($user) : AuthenticatedResponse::createFailed();
        }

        $token = $user->createToken($request['email']);
        return AuthenticatedResponse::login($user, $token);
    }

    protected function validateForm($request)
    {
        return $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required_if:mobile,null', 'string', 'email', 'unique:users,email'],
            'mobile' => ['required_if:email,null', 'numeric', new ValidPhoneNumber, 'unique:users,mobile'],
            'password' => ['required', Rules\Password::defaults()],
        ]);
    }
}
