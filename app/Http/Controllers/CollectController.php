<?php

namespace App\Http\Controllers;

use App\Models\Collect;
use App\Models\ProductCate;
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
        $collect = new Collect();
        $collect->member_id = $payload[0];
        $collect->products_id = $request->input('products_id');
        $collect->save();

        return response()->json($collect, 201);
    }

    // Read single collect by ID
    public function read(Request $request)
    {
        $payload = $this -> getPayload($request);
         // 取得原始搜尋結果
         $results = ProductCate::all();
         // 取得對應關係
         $productCate = $results->pluck('name')->toArray();
         $collect = Collect::whereIn('id', $productCate)
         ->where("member_id",$payload[0])
         ->get()
         ->keyBy('id');

        // 處理結果，將 id 替換成對應的 name
        $processedResults = $results->map(function ($item) use ($collect) {
            $item->name = $collect[$item->name]->name ?? 'unknown';
            unset($item->name); // 如果不需要 name_id，可以移除
            return $item;
        });

        return response()->json($processedResults);
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
        $id = $request -> input("id");
        $collect = Collect::where("member_id",$payload[0])
                            ->where("products_id",$id)
                            ->get();
        if ($collect){
            $collect->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'failed，not found userData'])
            ->setStatusCode(400);
    }

    protected function getPayload(Request $request){

        $token = new Token($request->bearerToken());
        $payload = JWTAuth::decode($token);

        return [$payload['id'],$payload['account']];
    }
}
