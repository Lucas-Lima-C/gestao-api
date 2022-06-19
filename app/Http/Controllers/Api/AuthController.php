<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\AuthRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    /**
     * @var UserService
     */
    protected $service;

    /**
     * AuthController constructor.
     *
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Method to authenticate User
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth(AuthRequest $request)
    {
        $data = $request->only(['email', 'password']);
        if ($token = JWTAuth::attempt($data)) {

            $return = Auth::user()->getAttributes();

            foreach ($return as $key => $value) {
                if (empty($value)) {
                    unset($return[$key]);
                }
            }
    
            unset($return['password']);
    
            //$return['photo'] = isset($return['photo']) ? env('APP_URL') . $return['photo'] : null;
            $return['access_token'] = $token;
            $return['token_type'] = 'bearer';
            $return['expires_in'] = 3600 * 8;
    
            return response()->json($return);
        }
        return response()->json('Credenciais Inválidas', 401);
    }

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        if($request->user()){
            return response()->json($request->user());
        }
        return response()->json('Credenciais Inválidas', 401);
    }

    /**
     * Method to invalidate the token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        JWTAuth::invalidate(JWTAuth::parseToken());
        return response()->json('Logout efetuado com sucesso.', 200);
    }
    /**
     * Method to refresh token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $condition = JWTAuth::getToken();
        if ($condition) {
            $token = JWTAuth::refresh($condition);
            return response()->json($token, 200);
        }
        return response()->json('Não foi possível refrescar o token', 500);
    }
}
