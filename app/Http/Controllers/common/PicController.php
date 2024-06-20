<?php
namespace App\Http\Controllers\common;
use Exception;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;

class PicController extends Controller
{
    public function saveDecodedImage(Request $request,$type)
    {   
        try{
            $base64_image = $request->input('base64_image'); // 從請求中獲取Base64字符串

            // 解碼Base64數據
            $image_data = base64_decode($base64_image);
    
            // 文件保存路徑
            $storage_path = storage_path("public/assets/{$type}"); // 假設將圖片保存在storage/app/public/images目錄下
            if (!file_exists($storage_path)) {
                mkdir($storage_path, 0777, true); // 如果目錄不存在，創建目錄
            }
    
            // 生成唯一的文件名
            $filename = uniqid() . '.jpg'; // 也可以根據需要使用不同的文件擴展名
    
            // 將解碼後的數據保存為文件
            $file_path = $storage_path . '/' . $filename;
            file_put_contents($file_path, $image_data);
    
            // 返回成功消息或者文件路徑
            return $file_path;
        }catch(Exception $e){
            return false;
        }
        
    }
}
