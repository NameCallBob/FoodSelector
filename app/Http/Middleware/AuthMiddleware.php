<?php

namespace App\Http\Middleware;
use Closure;
use Exception;

//  前端需求
use Illuminate\Http\Request;
// Aurh
use Illuminate\Support\Facades\Auth;
// JWT
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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

        return $next($request);
    }

    public function genToken($id){

    }

    public function checkToken($request){

    }
    public function login($account,$password){
        
    }

    /**
     * 帳號註冊
     * $request -> 前端需求
     */
    public function register($request){

    }
}
