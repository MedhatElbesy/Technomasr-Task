<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{
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
            $token = Auth::guard('admin-api')->attempt($credentials);

            if (!$token) {
                return ApiResponse::sendResponse(401, "Fail data credentials");
            }

            $admin = Auth::guard('admin-api')->user();
            $admin->api_token = $token;
            return ApiResponse::sendResponse(200, "Login Success", $admin);

        } catch (\Exception $ex) {
            return ApiResponse::sendResponse(500, 'Login Failed', $ex->getMessage());
        }
    }


    public function logout(Request $request)
    {
        try {
            Auth::guard('admin-api')->logout();

            return ApiResponse::sendResponse(200, "Logout Success");

        } catch (\Exception $ex) {
            return ApiResponse::sendResponse(500, 'Logout Failed', $ex->getMessage());
        }
    }
}
