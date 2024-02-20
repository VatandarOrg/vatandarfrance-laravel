<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\TwoFactor;
use App\Models\User;
use App\Services\Auth\TwoFactorAuthentication;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;

class PasswordResetLinkController extends Controller
{
    protected $twoFactor;

    public function __construct(TwoFactorAuthentication $twoFactor)
    {
        User::whereNotNull('mobile')->whereNull('mobile_verified_at')->where('created_at', '<', now()->subSeconds(130))->forceDelete();
        TwoFactor::where('created_at', '<', now()->subSeconds(120))->delete();

        $this->twoFactor = $twoFactor;
    }

    public function email(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['status' => __($status)]);
    }

    public function mobile(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'numeric', new ValidPhoneNumber, 'exists:users,mobile'],
        ]);

        $user = UserService::new()->findByMobile($request['mobile']);

        $result = $this->twoFactor->requestCode($user);
        return ($result == TwoFactorAuthentication::CODE_SENT) ? response()->json(['status' => 'success', 'message' => 'Password forgotten code sent successfully'], Response::HTTP_ACCEPTED) : response()->json(['status' => 'error', 'message' => 'There is a problem in the process of sending the forgotten code'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
