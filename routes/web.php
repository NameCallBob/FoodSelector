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
$router->get("/token/verify/","AuthController@tokencheck");

// 會員相關

// 輸出所有產品類別(買家、賣家)
$router->get("/product/cate/",'ProductCateController@all');
// 收藏商品

// 單一商品
$router->get("/product/info/{id}/",'ProductController@read');
// 所有商店
$router->get("/store/",'StoreInfoController@all');
// 商店商品
$router->get("/store/goods/{store_id}/",'ProductController@store_data');
// 商店查詢
$router->get("/store/search",'');
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
// $router->get('/product/collect_rank/','');

// 商品上下架
$router->post('/product/edit/status/','ProductController@changestatus');
// 商品資訊修改
$router->post('/product/edit/update/','ProductController@update');
// 新增商品
$router->post('/product/edit/add/','ProductController@create');
// 刪除商品
$router->post('/product/edit/delete/','ProductController@delete');
// 商店所有商品
$router->get("/product/edit/all/",'ProductController@store_allProduct');


