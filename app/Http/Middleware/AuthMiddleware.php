<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
// 紀錄
use Log;
//  前端需求
use Illuminate\Http\Request;
// JWT
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
//
use App\Models\PrivateModel;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\StoreController;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 檢查使用者是否有權限執行該操作
        if ($this->hasPermission($request->user(), $this->getRouteName($request))) {
            return $next($request);
        } else {
            // 確認是否是做登入註冊
            $action = $this->getRouteName($request);
            if ($action == "user.login") {
                $AuthController = new AuthController();
                return $AuthController->login($request);
            } else if ($action == "member.register") {
                $MemberController = new MemberController();
                return $MemberController->create($request);
            } else if ($action == "store.register") {
                $StoreController = new StoreController();
                return $StoreController->create($request);
            }
        }
        // 沒有權限時,返回錯誤訊息或重定向
        return response()->json(['error' => '您沒有權限執行此操作'], 403);
    }

    protected function hasPermission($user, $action)
    {
        echo $action;
        return true;
    }
    /**
     * 確認JWTtoken是否有效
     * return 使用者id
     */
    public function verifyToken(Request $request)
    {
        $token = $request->bearerToken();

        try {
            $payload = JWTAuth::decode($token);

            // 在這裡您可以自行驗證 payload 數據
            $id = $payload['id'];
            $account = $payload['account'];

            $privateModel = PrivateModel::where('id', $id)
                ->where('account', $account)
                ->first();
            // 根據您的需求進行後續的驗證和操作
            if ($privateModel) {
                // 驗證通過
                return $id;
            } else {
                // 驗證失敗
                return response()->json(['error' => 'Invalid token'], 401);
            }
        } catch (JWTException $e) {
            // 令牌解碼失敗
            return response()->json(['error' => 'Invalid token'], 401);
        }
    }
    private function getRouteName(Request $request)
    {
        $route = $request->route();
        if ($route === null) {
            Log::error('Route is null for the request: ' . $request->fullUrl());
            return null;
        }

        return $route->getName();
    }
    /**
     * 帳號註冊
     * $request -> 前端需求
     */
    public function register($request)
    {

    }
}
