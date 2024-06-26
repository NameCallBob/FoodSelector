<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Support\Str;


use Illuminate\Http\Request;
use App\Models\PrivateModel;
use App\Models\Member;
// use App\Http\Controllers\LockController;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\LockController;
use Laravel\Lumen\Routing\Controller;
use Tymon\JWTAuth\Token;

use App\Http\Middleware\AuthMiddleware;

use Illuminate\Http\JsonResponse; // 确保引入 JsonResponse 类

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('account', 'password');
        try{
            $ob = PrivateModel::where("account",$request->input('account'))
            ->get()->firstOrFail();
            if(LockController::checklock($ob->id)){
                return response()->json(['error' => 'account be locked'], 400);
            }
        }catch(Exception $e){
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        try {
            if (! $token = auth()->attempt($credentials)) {
                LockController::incrementCount($ob->id);
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        LockController::emptyRecord($ob->id);
        return response()->json(compact('token'))->setStatusCode(200);
    }
    public function checktoken(Request $request){
        $res = AuthMiddleware::verifyToken($request);
        if ($res != false){
            return response() -> json(['message' => 'ok']);
        }
        return response() -> json(['err' => 'token invalid'],401);
    }
    public static function getPayload(Request $request){
        try{
            $token = new Token($request->bearerToken());
            $payload = JWTAuth::decode($token);
            return [$payload['id'],$payload['account']];
        }catch(Exception $e){
            return false;
        }
    }

    public function forgotPassword(Request $request){
        $account = $request -> input("account");
        try{
            $private = PrivateModel::where("account",$account)
            ->get()
            ->firstOrFail();
            $member_id = $private -> member -> id;
            $ob = Member::find($member_id);
            if ($ob -> safe_ans1 == $request -> input('ans1') and $ob -> safe_ans2 == $request -> input('ans2')){
                LockController::emptyRecord($private -> id);
                $password = Str::random(12);
                $ob = PrivateModel::find($private->id);
                $ob -> updatePassword($password);

                return response() -> json(['password' => $password],200);
            }else{
                return response() -> json(['err' => 'Account or Answer is  Wrong!'],400);
            }
        }catch(Exception $e){
            return response() -> json(['err' => 'Account or Answer is  Wrong!'],400);
        }

    }
}
