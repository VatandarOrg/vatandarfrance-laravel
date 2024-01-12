<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\Auth\AuthenticatedResponse;
use App\Services\User\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validateForm($request);

        $inputs = $request->only('first_name', 'last_name', 'email', 'username', 'provider', 'provider_id') + ['password' => Hash::make($request->password)];

        event(
            new Registered(
                $user = UserService::new()
                    ->create($inputs)
                    ->getOrSend([AuthenticatedResponse::class, 'registerFailed'])
            )
        );

        $token = $user->createToken($request['username']);

        return AuthenticatedResponse::login($user, $token);
    }

    protected function validateForm($request)
    {
        return $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'username' => ['required', 'string', 'unique:users,username', 'regex:/^[a-z0-9_.]{3,20}$/'],
            'password' => ['required', Rules\Password::defaults()],
            'provider' => ['nullable'],
            'provider_id' => ['nullable']
        ]);
    }
}
