<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Routing\Controller;

class PhotoController extends Controller
{
    // 顯示指定照片
    public function show($folder, $filename)
    {
        $path = storage_path("app/photos/{$folder}/{$filename}");

        if (!file_exists($path)) {
            return response()->json(['message' => 'Photo not found'], 404);
        }

        return response()->file($path);
    }
}
