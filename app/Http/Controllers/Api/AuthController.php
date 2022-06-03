<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogUserRequest;

class AuthController extends Controller
{
    /**
     * AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => 'login']);
    }

    /**
     * Returns JWT if credentials are valid.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LogUserRequest $request) {
        if (!($token = auth()->attempt($request->validated()))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->responseWithToken($token);
    }

    /**
     * Logs the user out
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Returns the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        return response()->json(auth()->user());
    }

    /**
     * Refresh JWT token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->responseWithToken(auth()->refresh());
    }

    /**
     * Returns response object with the given token
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseWithToken(string $token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}

