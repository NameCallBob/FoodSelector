<?php

namespace App\Http\Controllers;

use App\Models\Collect;
use App\Models\ProductCate;
use App\Models\Product;
use App\Models\PrivateModel;
use Exception;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;


class CollectController extends Controller
{
    // Create new collect
    public function create(Request $request)
    {
        $payload = $this -> getPayload($request);
        $member_id = PrivateModel::find($payload[0]) -> member -> id;
        $collect = new Collect();
        $collect->member_id = $member_id;
        $collect->products_id = $request->input('products_id');
        $collect->save();

        return response()->json($collect, 201);
    }

    // Read single collect by ID
    public function read(Request $request)
    {
        $payload = $this -> getPayload($request);
        $member_id = PrivateModel::find($payload[0]) -> member -> id;

        $collect = Collect::where("member_id",$member_id)
                ->get();
    }

    // Read collects with conditions
    public function readByConditions(Request $request)
    {
        $query = Collect::query();

        if ($request->has('member_id')) {
            $query->where('member_id', $request->input('member_id'));
        }

        if ($request->has('products_id')) {
            $query->where('products_id', $request->input('products_id'));
        }

        $result = $query->get();
        return response()->json($result);
    }

    // Update collect by ID
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'member_id' => 'required|exists:members,id',
            'products_id' => 'required|exists:products,id',
        ]);

        $collect = Collect::findOrFail($id);
        $collect->member_id = $request->input('member_id');
        $collect->products_id = $request->input('products_id');
        $collect->save();

        return response()->json($collect);
    }

    // Delete collect by ID
    public function delete(Request $request)
    {
        $payload = $this -> getPayload($request);
        $member_id = PrivateModel::find($payload[0]) -> member -> id;

        $id = $request -> input("products_id");
        $collect = Collect::where("member_id",$member_id)
                            ->where("products_id",$id)
                            ->get();
        if ($collect){
            foreach ($collect as $col) {
                $col->delete(); // 刪除每個用戶
            }
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'failed，not found userData'])
            ->setStatusCode(400);
    }
    // 店家

    public function getCollectRank(Request $request){
        $payload = $this -> getPayload($request);
        $store_id = PrivateModel::find($payload[0]) -> store -> id;

        // 從 products 資料表中取得符合 store_id 的所有產品
        $products = Product::where('store_id', $store_id)->get();

        return Collect::getCollectRank($products);

    }
    protected function getPayload(Request $request){
        try{
            $token = new Token($request->bearerToken());
            $payload = JWTAuth::decode($token);

            return [$payload['id'],$payload['account']];
        }catch(Exception $e){
            return false;
        }

    }
}
