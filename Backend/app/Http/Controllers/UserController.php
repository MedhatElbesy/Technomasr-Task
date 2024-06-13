<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

// use Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $rules = [
                'username' => 'required|unique:users',
                'password' => 'required|min:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return ApiResponse::sendResponse(400, 'Validation error', $validator->errors());
            }

            $user = new User();
            $user->username = $request->input('username');
            $user->password = bcrypt($request->input('password'));
            $user->save();

            $token = JWTAuth::fromUser($user);
            $user->api_token = $token;
            return ApiResponse::sendResponse(200, 'Registration successful', $user);

        } catch (\Exception $ex) {
            return ApiResponse::sendResponse(500, 'Registration failed', $ex->getMessage());
        }
    }
    public function login(Request $request)
{
    try {
        $rules = [
            "username" => "required",
            "password" => "required"
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(401, "Fail data");
        }

        $credentials = $request->only(['username', 'password']);
        $token = Auth::guard('user-api')->attempt($credentials);

        if (!$token) {
            return ApiResponse::sendResponse(401, "Fail data credentials");
        }

        $user = Auth::guard('user-api')->user();
        $user->api_token = $token;
        return ApiResponse::sendResponse(200, "Login Success", $user);

    } catch (\Exception $ex) {
        return ApiResponse::sendResponse(500, 'Login Failed', $ex->getMessage());
    }
}


    public function logout(Request $request)
    {
        try {
            Auth::guard('user-api')->logout();

            return ApiResponse::sendResponse(200, "Logout Success");

        } catch (\Exception $ex) {
            return ApiResponse::sendResponse(500, 'Logout Failed', $ex->getMessage());
        }
    }

}
