<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\Auth\AuthenticatedResponse;
use App\Models\Device;
use App\Services\Device\DeviceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthenticatedController extends Controller
{
    public function me()
    {
        $user = auth()->user();

        return AuthenticatedResponse::me($user);
    }

    public function destroy()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json(["status" => "success", "message" => "Success! Logout completed"]);
    }

    public function isValidUsername($username)
    {
        $validator = Validator::make(['username' => $username], [
            'username' => 'unique:users,username,regex:/^[a-z0-9_.]{3,20}$/',
        ]);

        return AuthenticatedResponse::isValid(!$validator->fails());
    }
}
