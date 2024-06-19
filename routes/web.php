<?php
use App\Http\Controllers\ProductController;

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// 登入
$router->post('login', ['uses' => 'AuthController@login', 'as' => 'user.login']);

// 會員相關

// 收藏商品

// 單一商品
$router->get("/product/info/{id}/",'ProductController@read');
// 商店商品
$router->get("/store/{store_id}",'ProductController@store_data');
// 商品查詢
$router->get("/search/",'ProductController@readByConditions');

// 店家相關

// 瀏覽、收藏次數

// 商品收藏排名

// 商品上下架

// 商品資訊修改

// 新增商品
