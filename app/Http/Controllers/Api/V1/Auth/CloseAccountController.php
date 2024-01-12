<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\Auth\AuthenticatedResponse;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Response;

class CloseAccountController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        if (request()->username != $user->username) {
            return response()->json(["status" => "error", "message" => "username invalid!"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = UserService::make($user)
            ->delete()
            ->getOrSend([AuthenticatedResponse::class, 'destroyFailed']);

        return AuthenticatedResponse::destroy();
    }

}
