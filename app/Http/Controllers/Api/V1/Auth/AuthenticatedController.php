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
}
