<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;
use App\Models\TwoFactor;
use App\Models\User;

class TwoFactorAuthentication
{
    const CODE_SENT = 'code.sent';
    const CODE_NOT_SEND = 'code.not.send';
    const INVALID_CODE = 'code.invalid';
    const ACTIVATED = 'code.activated';
    const AUTHENTICATED = 'code.authenticated';
    const USER_NOT_FOUND = 'user.not.found';
    protected $request;
    protected $code;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function requestCode(User $user)
    {
        $response = true;
        if ($user->code == null) {
            $code = TwoFactor::generateCodeFor($user);

            $response = $code->send();
        }

        return ($response) ? static::CODE_SENT : static::CODE_NOT_SEND ;
    }

    public function resend()
    {
        $user = $this->getUser();

        if (!$user) return static::USER_NOT_FOUND;

        // if ($user->code == null) return $this->requestCode($user);
        return $this->requestCode($user);
    }

    public function activate()
    {
        if (!$this->getToken()) return static::INVALID_CODE;
        if (!$this->isValidCode()) return static::INVALID_CODE;

        $this->getToken()->delete();

        return static::ACTIVATED;
    }

    public function deactivate(User $user)
    {
        return $user->deactivateTwoFactor();
    }

    protected function isValidCode()
    {
        return !$this->getToken()->isExpired() && $this->getToken()->isEqualWith($this->request->code);
    }

    protected function getToken()
    {
        return $this->code ?? $this->code =  TwoFactor::where('user_id', $this->getUser()->id)->first();
    }

    protected function getUser()
    {
        return User::firstWhere('mobile', $this->request['mobile']);
    }
}
