<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Responses\Auth\AuthenticatedResponse;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\Auth\TwoFactorResponse;
use App\Services\Auth\TwoFactorAuthentication;
use App\Models\TwoFactor;
use App\Services\Device\DeviceService;

class TwoFactorController extends Controller
{
    protected $twoFactor;

    public function __construct(TwoFactorAuthentication $twoFactor)
    {
        TwoFactor::where('created_at', '<', now()->subSeconds(120))->delete();

        $this->twoFactor = $twoFactor;
    }

    public function resend()
    {
        $response = $this->twoFactor->resend();

        return match ($response) {
            $this->twoFactor::CODE_SENT => TwoFactorResponse::resendCode(),
            $this->twoFactor::USER_NOT_FOUND => TwoFactorResponse::userNotFound(),
        };
    }

    public function confirmCode(Request $request)
    {
        $this->validateForm($request);

        $response = $this->twoFactor->activate();

        if ($response !== $this->twoFactor::ACTIVATED) {
            return TwoFactorResponse::refuseCode();
        }

        $user = UserService::new()->findByMobile($request['mobile']);

        $user = UserService::make($user)
            ->update([
                'mobile_verified_at' => now()
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
        ]);
    }
}
