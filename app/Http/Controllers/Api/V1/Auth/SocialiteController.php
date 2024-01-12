<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Responses\Auth\AuthenticatedResponse;
use App\Services\User\Auth\Manager\AppleManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;

class SocialiteController extends Controller
{
    const TOKEN_INVALID = 'token.invalid';

    public function __invoke(Request $request)
    {
        $check = $this->checkWithProvider($request);

        $this->validateForm($request);

        if ($check == static::TOKEN_INVALID) {
            return $this->sendTokenInvalidResponse();
        }

        $user = User::whereEmail($request['email'])->first();

        $token = $user->createToken($user['username']);

        return AuthenticatedResponse::login($user, $token);
    }

    protected function validateForm($request)
    {
        return $request->validate([
            'email' => ['required', 'string', 'email', 'exists:users,email'],
            'provider' => 'required',
            'provider_id' => 'required'
        ]);
    }

    protected function checkWithProvider($request)
    {
        switch ($request['provider']) {
            case 'google':
                $response = Http::get('https://oauth2.googleapis.com/tokeninfo?id_token=' . $request['provider_id']);
                if ($response->status() == 400) {
                    return static::TOKEN_INVALID;
                }
                $request['email'] = $response->json()['email'];
                break;
            case 'apple':
                $response = Http::asForm()->post('https://appleid.apple.com/auth/token', [
                    'client_id' => config()->get('services.apple.client_id'),
                    'client_secret' => config()->get('services.apple.client_secret'),
                    'code' => $request['provider_id'],
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => 'https://google.com'
                ]);
                if (!$response->ok()) {
                    return static::TOKEN_INVALID;
                }
                break;
            default:

                break;
        }
    }
    protected function sendTokenInvalidResponse()
    {
        return response()->json(["status" => "error", "message" => 'token invalid'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
