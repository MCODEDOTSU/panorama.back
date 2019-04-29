<?php

namespace App\src\Services\Auth;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * @param $request
     * @return bool
     * Логин по email
     */
    public function login($request)
    {
        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(4);
        $token->save();

        $role = $this->resolveRole($request->email);

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'role' => $role
        ]);

    }

    protected function resolveRole($email)
    {
        if ($email === 'admin@admin.ru') {
            return 'superadmin';
        } else {
            return 'admin';
        }
    }

}
