<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\PrivateModel;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Laravel\Lumen\Routing\Controller;
use Tymon\JWTAuth\Token;

use App\Http\Middleware\AuthMiddleware;

use Illuminate\Http\JsonResponse; // 确保引入 JsonResponse 类

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('account', 'password');

        try {
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'))->setStatusCode(200);
    }
    public function checktoken(){
        $ob = new AuthMiddleware();
        $res = $ob -> verifyToken();
        if ($res){
            return response();
        }
    }
    public function getPayload(Request $request){
        try{
            $token = new Token($request->bearerToken());
            $payload = JWTAuth::decode($token);
            return [$payload['id'],$payload['account']];
        }catch(Exception $e){
            return false;
        }
    }
}
