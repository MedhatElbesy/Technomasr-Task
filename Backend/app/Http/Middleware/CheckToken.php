<?php

namespace App\Http\Middleware;
use App\Helpers\ApiResponse;
use App\Models\Admin;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $guard = null)
{
    auth()->shouldUse($guard);
    $token = $request->header('auth-token');
    // $request->headers->set('auth-token', (string) $token, true);
    // $request->headers->set('Authorization', 'Bearer '.$token, true);
    try {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user && $this->userExists($guard, $user->username)) {
            return $next($request);
        }
    } catch (TokenExpiredException $e) {
        return ApiResponse::sendResponse(401, 'Unauthenticated user');
    } catch (JWTException $e) {
        return ApiResponse::sendResponse(500, 'token_invalid', ['error' => $e->getMessage()]);
    }
}

protected function userExists($guard, $username)
{
    if ($guard == 'admin-api') {
        return Admin::where('username', $username)->exists();
    }
    return User::where('username', $username)->exists();
}

}
