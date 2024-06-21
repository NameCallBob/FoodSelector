<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

use Illuminate\Support\Facades\Route;


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

// Role permissions
use App\Models\UserRole;
use App\Models\Role;
use App\Models\Permission;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$permission=null)
    {
        if ($this->shouldAuthenticate($request)) {
            // 檢查使用者是否有權限執行該操作
            if ($this->hasPermission($request,$permission)) {
                return $next($request);
            }
            // 沒有權限時,返回錯誤訊息或重定向
            return response()->json(['error' => '您沒有權限執行此操作'],403);

        }
        return $next($request);
    }

    protected function hasPermission(Request $request,$permissionName)
    {
        // echo $permission;
        if($permissionName == null){
            // 無須權限
            return true;
        }
        else if ($permissionName){
            $privateId = self::verifyToken($request);
            if ($privateId){
                $userRole = UserRole::where('private_id', $privateId)->first();

                if (!$userRole) {
                    return false; // 如果找不到使用者角色，則返回false
                }

                // 找出角色對應的所有權限ID
                $role = Role::find($userRole->role_id);

                if (!$role) {
                    return false; // 如果找不到角色，則返回false
                }

                $permissions = $role->permissions()->pluck('permission_id')->toArray();

                // 找出權限的ID
                $permission = Permission::where('action_name', $permissionName)->first();

                if (!$permission) {
                    return false; // 如果找不到指定的權限，則返回false
                }

                // 檢查權限是否在角色擁有的權限中
                return in_array($permission->id, $permissions);
            }
            return response() -> json(['err' => 'token is invalid'],401);
        }
        return false;



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
