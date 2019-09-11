<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Jobs\SendEmailRegisterUser;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    protected $authService;

    /**
     * AuthController constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Create user
     *
     * @param  [UserRequest] $request
     *
     * @return JsonResponse
     */
    public function signup(UserRequest $request)
    {
        $user = $this->authService->createUser($request);

        SendEmailRegisterUser::dispatch($user)
            ->delay(now()->addMinutes(1));

        return response()->json(
            [
                'message' => trans('auth.create_success'),
                'user' => $user
            ], 201
        );
    }

    /**
     * @param  [LoginRequest] $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request);

        return response()->json($token, $token->status());
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::user()->token()->revoke();

        return response()->json(
            [ 'message' => trans('auth.logout_success') ]
        );
    }
}
