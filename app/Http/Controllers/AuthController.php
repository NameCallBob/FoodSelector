<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * 處理登入請求
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // 取得account和password
        $account = $request->input('account');
        $password = $request->input('password');

        // 在Member資料庫中尋找
        $member = Member::where('account', $account)->first();

        // 如果找到會員且密碼正確
        if ($member && Hash::check($password, $member->password)) {
            
            return response()->json([
                'message' => '登入成功',
                'token' => $token
            ], 200);
        } else {
            // 返回錯誤訊息
            return response()->json([
                'message' => '帳號或密碼錯誤'
            ], 401);
        }
    }
}
