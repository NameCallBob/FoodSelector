<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Look;
use App\Models\Product;
use App\Models\PrivateModel;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Laravel\Lumen\Routing\Controller;

class ProductController extends Controller
{
    // Create new product
    public function create(Request $request)
    {
        $store_id = $this -> getStoreId($request);
        try{
            $this->validate($request, [
                'product_cate_id' => 'required|exists:product_cate,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'status' => 'required|numeric|min:0',
            ]);
        }catch(Exception $e){
            return response() -> json(['err' => 'Wrong Query,check the params is [product_cate_id,name,description,price,status]'], 400);
        }

        $product = new Product();
        $product->product_cate_id = $request->input('product_cate_id');
        $product->store_id = $store_id;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->picUrl = "null" ;
        $product->status = $request->input('status');
        $product->save();

        return response()->json($product, 201);
    }

    // Read single product by ID
    public function read($id)
    {
        $product = Product::where(
            'id',$id)->get();;
        if ($product){
            return response()->json($product);
        }
        return response()->json($product)->setStatusCode(404);;
    }

    /**
     * 給使用者使用，利用前端傳的store_id查詢
     */
    public function store_data($store_id){
        $product = Product::where(
            'store_id',$store_id)->get();
        if ($product){
            Look::addLook($store_id);
            return response()->json($product);
        }
        return response()->json($product)->setStatusCode(404);
    }

    /**
     * 給賣家使用，從token拿取他的編號自動查詢
     */
    public function store_allProduct(Request $request){
        $store_id = $this -> getStoreId($request);
        $product = Product::where(
            'store_id',$store_id)->get();
        if ($product){
            // Look::addLook($store_id);
            return response()->json($product);
        }
        return response()->json($product)->setStatusCode(404);
    }

    // Read products with conditions
    public function readByConditions(Request $request)
    {
        $query = Product::query();

        if ($request->has('product_cate_id')) {
            $query->where('product_cate_id', $request->input('product_cate_id'));
        }

        if ($request->store_id) {
            $query->where('store_id', $request->input('store_id'));
        }

        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        $result = $query->get();
        return response()->json($result);
    }

    // Update product by ID
    public function update(Request $request)
    {
        $this->validate($request, [
            'product_cate_id' => 'required|exists:product_cates,id',
            'store_id' => 'required|exists:store,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'picUrl' => 'required|string',
            'status' => 'required|numeric|min:0'
        ]);

        $product = Product::findOrFail($request -> input('$products_id'));
        $product->product_cate_id = $request->input('product_cate_id');
        $product->store_id = $request->input('store_id');
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->picUrl = $request->input('picUrl');
        $product->status = $request->input('status');
        $product->save();

        return response()->json(['message' => 'ok']);
    }

    // Update product status by ID
    public function changestatus(Request $request)
    {
        try{
            $this -> validate($request,[
                'status' => 'required|numeric|min:0|max:1'
            ]);
        }catch(Exception $e){
            return response() -> json(['err' => 'Wrong format about status,please check is number and between 0 and 1'],400);
        }

        try{
            $product = Product::findOrFail($request -> input('products_id'));
        }catch(Exception $e){
            return response() -> json(['err' => 'No Data'],404);
        }
        if(($product->status) != ($request->input('status'))){
            $product->status = $request->input('status');
            $product->save();
            return response()->json(['message' => 'OK']);
        }
        return response() -> json(['err' => 'you send the status,same as db data'],400);
    }

    // Delete product by ID
    public function delete(Request $request)
    {
        $store_id = $this ->getStoreId($request);
        try{
            $id = $request->input("products_id");
            $product = Product::getStoreSingleProduct($store_id,$id);
            if ($product){
                foreach($product as $pro){
                    $pro->delete();
                }
                return response()->json(['message' => 'Deleted successfully']);
            }
            else{
                return response()->json(['err' => 'No Data'],404);
            }
        }catch(Exception $e){
            return response()->json(['err' => 'No Data'],404);
        }



    }

    /**
     * 從Private資料拿取storeID
     */
    protected function getStoreId(Request $request){
        $payload = AuthController::getPayload($request);
        $store_id = PrivateModel::find($payload[0]) -> store -> id;
        return $store_id;
    }
}
