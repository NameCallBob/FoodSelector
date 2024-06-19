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
use Tymon\JWTAuth\Token;
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
        if ($this->shouldAuthenticate($request)) {
            // 檢查使用者是否有權限執行該操作
            if ($this->hasPermission()) {
                return $next($request);
            }
            // 沒有權限時,返回錯誤訊息或重定向
            return response()->json(['error' => '您沒有權限執行此操作']);

        }
        return $next($request);
    }

    protected function hasPermission()
    {
        return true;
    }
    /**
     * 確認JWTtoken是否有效
     * return 使用者id
     */
    public static function verifyToken(Request $request)
    {
        try {
            $token = new Token($request->bearerToken());
            $payload = JWTAuth::decode($token);

            // Validate payload data
            $id = isset($payload['id']) ? $payload['id'] : null;
            $account = isset($payload['account']) ? $payload['account'] : null;

            if ($id && $account) {
                $privateModel = PrivateModel::where('id', $id)
                    ->where('account', $account)
                    ->first();

                if ($privateModel) {
                    return $id;
                }
            }

            return false;
        } catch (JWTException $e) {
            Log::error('JWT Exception: ' . $e->getMessage());
            return false;
        }
    }
    /**
     * 判斷是否需要進行身份驗證
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function shouldAuthenticate($request)
    {
        // 定義不需要驗證的路徑
        $exceptPaths = [
            'login',
            'member/register/',
            'store/register/'
        ];

        // 檢查請求路徑是否在例外清單中
        foreach ($exceptPaths as $path) {
            if ($request->is($path)) {
                return false;
            }
        }

        return true;
    }

}
