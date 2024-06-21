<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StoreInfo;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class RandomController extends Controller
{
    public function getRandomProduct(){
        $randomProducts = Product::inRandomOrder()->limit(4)->get();
        return response()->json($randomProducts);
    }

    public function getRandomStore(){
        $randomStoreInfos = StoreInfo::inRandomOrder()->limit(4)->get();
        return response()->json($randomStoreInfos);
    }
}
