<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\Auth\AuthenticatedResponse;
use App\Http\Responses\Auth\TwoFactorResponse;
use App\Models\TwoFactor;
use App\Services\Auth\TwoFactorAuthentication;
use App\Services\User\UserService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    protected $twoFactor;

    public function __construct(TwoFactorAuthentication $twoFactor)
    {
        TwoFactor::where('created_at', '<', now()->subSeconds(120))->delete();

        $this->twoFactor = $twoFactor;
    }

    public function email(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(["status" => "success", "message" => __($status)]);
    }

    public function mobile(Request $request)
    {
        $this->validateForm($request);

        $response = $this->twoFactor->activate();

        if ($response !== $this->twoFactor::ACTIVATED) {
            return TwoFactorResponse::refuseCode();
        }

        $user = UserService::new()->findByMobile($request['mobile']);

        $user = UserService::make($user)
            ->update([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])
            ->getOrSend([AuthenticatedResponse::class, 'updateFailed']);

        $token = $user->createToken($user->mobile);

        return TwoFactorResponse::confirmCode($token, $user->roles, $user);
    }

    protected function validateForm($request)
    {
        return $request->validate([
            'code' => 'required|numeric|digits:4|exists:two_factors',
            'mobile' => 'required|numeric|exists:users,mobile',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }
}
