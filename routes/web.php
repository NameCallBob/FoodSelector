<?php
use App\Http\Controllers\ProductController;

/** @var \Laravel\Lumen\Routing\Router $router */

// 照片
use Illuminate\Support\Facades\Storage;

$router->get('/photos/{folder}/{filename}', 'PhotoController@show');



$router->get('/', function () use ($router) {
    return $router->app->version();
});

// 登入
$router->post('login', ['uses' => 'AuthController@login', 'as' => 'user.login']);
$router->post("forgotpassword",'AuthController@forgotPassword');
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
// $router->post("/product/collect/",'CollectController@create');
// // 列出個人收藏
// $router->get("/collect/",'CollectController@read');
// // 刪除個人收藏
// $router->post("/collect/delete/",'CollectController@delete');


// // 店家相關
// $router->get("/store/info/",'StoreInfoController@verify_info');

// $router->post('/store/changeInfo/','StoreInfoController@update');
// // 瀏覽、收藏次數
// $router->get("/store/look/",'StoreInfoController@getlookAndCollect');
// // 商品收藏排名
// $router->get('/product/collect_rank/','CollectController@getCollectRank');

// // 商品上下架
// $router->post('/product/edit/status/','ProductController@changestatus');
// // 商品資訊修改
// $router->post('/product/edit/update/','ProductController@update');
// // 新增商品
// $router->post('/product/edit/add/','ProductController@create');
// // 刪除商品
// $router->post('/product/edit/delete/','ProductController@delete');
// // 商店所有商品
// $router->get("/product/edit/all/",'ProductController@store_allProduct');

// // 隨機
// $router->get("/random/product/",'RandomController@getRandomProduct');
// $router->get("/random/store/",'RandomController@getRandomStore');


$router->post("/product/collect/", [
    'as' => 'collect.create',
    'uses' => 'CollectController@create',
    'middleware' => 'check.permission:collect.create',
]);

$router->get("/collect/", [
    'as' => 'collect.read',
    'uses' => 'CollectController@read',
    'middleware' => 'check.permission:collect.read',
]);

$router->post("/collect/delete/", [
    'as' => 'collect.delete',
    'uses' => 'CollectController@delete',
    'middleware' => 'check.permission:collect.delete',
]);

$router->get("/store/info/", [
    'as' => 'store.info',
    'uses' => 'StoreInfoController@verify_info',
    'middleware' => 'check.permission:store.info',
]);

$router->post('/store/changeInfo/', [
    'as' => 'store.changeInfo',
    'uses' => 'StoreInfoController@update',
    'middleware' => 'check.permission:store.changeinfo',
]);

$router->get("/store/look/", [
    'as' => 'store.lookAndCollect',
    'uses' => 'StoreInfoController@getlookAndCollect',
    'middleware' => 'check.permission:store.getlookAndCollect',
]);

$router->get('/product/collect_rank/', [
    'as' => 'product.collectRank',
    'uses' => 'CollectController@getCollectRank',
    'middleware' => 'check.permission:product.collect_rank',
]);

$router->post('/product/edit/status/', [
    'as' => 'product.editStatus',
    'uses' => 'ProductController@changestatus',
    'middleware' => 'check.permission:product.edit.status',
]);

$router->post('/product/edit/update/', [
    'as' => 'product.editUpdate',
    'uses' => 'ProductController@update',
    'middleware' => 'check.permission:product.edit.update',
]);

$router->post('/product/edit/add/', [
    'as' => 'product.editAdd',
    'uses' => 'ProductController@create',
    'middleware' => 'check.permission:product.edit.create',
]);

$router->post('/product/edit/delete/', [
    'as' => 'product.editDelete',
    'uses' => 'ProductController@delete',
    'middleware' => 'check.permission:product.edit.delete',
]);

$router->get("/product/edit/all/", [
    'as' => 'product.all',
    'uses' => 'ProductController@store_allProduct',
    'middleware' => 'check.permission:product.edit.all',
]);

$router->get("/random/product/", [
    'as' => 'random.product',
    'uses' => 'RandomController@getRandomProduct'
]);

$router->get("/random/store/", [
    'as' => 'random.store',
    'uses' => 'RandomController@getRandomStore'
]);
