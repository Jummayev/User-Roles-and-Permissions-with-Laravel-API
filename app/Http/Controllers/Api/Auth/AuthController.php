<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['user_login', 'admin_login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_login()
    {
        $credentials = request()->only(['email', 'password']);

        if (!($token = auth()->guard('user-api')->attempt($credentials) )) {
            return response()->json([
                'success' => false,
                'message' => "email or password error",
                'error' => 'Unauthorized'
            ], 401);
        }
        $user = Auth::guard('user-api')->user();

        return response()->json([
            'success' => true,
            'message' => "successful login",
            'user' => $user,
            'token' => $token,
        ]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function admin_login()
    {
        $credentials = request()->only(['email', 'password']);

        if (!($token = auth()->guard('admin-api')->attempt($credentials) )) {
            return response()->json([
                'success' => false,
                'message' => "email or password error",
                'error' => 'Unauthorized'
            ], 401);
        }
        $user = Auth::guard('admin-api')->user();

        return response()->json([
            'success' => true,
            'message' => "successful login",
            'user' => $user,
            'token' => $token,
        ]);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
