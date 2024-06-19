<?php
use App\Http\Controllers\ProductController;

/** @var \Laravel\Lumen\Routing\Router $router */

// 照片
Route::get('/photos/{filename}', function ($filename) {
    $path = storage_path('app/photos/' . $filename);

    if (!Storage::exists('photos/' . $filename)) {
        abort(404, 'File not found');
    }

    return response()->file($path);
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// 登入
$router->post('login', ['uses' => 'AuthController@login', 'as' => 'user.login']);
$router->get("/api/token/verify/","AuthController@tokencheck");

// 會員相關

// 輸出所有產品類別
$router->get("/product/cate/",'ProductCateController@all');
// 收藏商品
$router->get("/product/collect/",'');
// 單一商品
$router->get("/product/info/{id}/",'ProductController@read');
// 所有商店
$router->get("/store/",'StoreInfoController@all');
// 商店商品
$router->get("/store/goods/{store_id}/",'ProductController@store_data');

// 商品查詢
$router->get("/search/",'ProductController@readByConditions');

// 收藏
$router->post("/product/collect/",'CollectController@create');
// 列出個人收藏
$router->get("/collect/",'CollectController@read');
// 刪除個人收藏
$router->post("/collect/delete/",'CollectController@delete');


// 店家相關
$router->get("/store/info/",'StoreInfoController@verify_info');
// 瀏覽、收藏次數
$router->get("/store/look/",'StoreInfoController@getlookAndCollect');

// 商品收藏排名

// 商品上下架

// 商品資訊修改

// 新增商品
