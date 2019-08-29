<?php
namespace App\Services;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\LaravelBaseApiException;

class AuthService
{
    /**
     * @param SignupRequest $request
     * @return array
     */
    public function createUser($request) {
        $data = $request->only([
            'email',
            'password',
            'name',
        ]);

        $data['password'] = bcrypt($data['password']);

        return User::create($data);
    }

/**
     * @param LoginRequest $request
     * @return array
     */
    public function login($request) {
        $data = $request->only([
            'email',
            'password',
        ]);

        if(! Auth::attempt($data)){
            throw new LaravelBaseApiException('unauthorized');
        }else{
            $user = Auth::user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'user' => $user,
            ]);
        }
    }

}
