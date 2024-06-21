<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class Collect extends Model
{
    protected $table = 'collect';

    protected $fillable = [
        'member_id', 'products_id',
    ];

    public static function getCollect($ids)
        {
            // 取得今天的日期
            $today = Carbon::now()->toDateString();

            // 取得全部和今天的數量
            $allCounts = self::whereIn('products_id', $ids)
                        ->select('products_id', DB::raw('COUNT(*) as count'))
                        ->groupBy('products_id')
                        ->get();

            $dayCounts = self::whereIn('products_id', $ids)
                        ->whereDate('created_at', $today)
                        ->select('products_id', DB::raw('COUNT(*) as count'))
                        ->groupBy('products_id')
                        ->get();

            // 計算總計和今天的總計
            $allTotal = $allCounts->sum('count');
            $dayTotal = $dayCounts->sum('count');

            return [$dayTotal, $allTotal];
        }
    public static function getCollectRank($products){
        $productIds = $products->pluck('id');

       // 查詢 collect 資料表並計算每個 product_id 的數量
       $collectCounts = Collect::select('products_id', DB::raw('count(*) as total'))
       ->whereIn('products_id', $productIds)
       ->groupBy('products_id')
       ->pluck('total', 'products_id');

       $results = $products->map(function ($product) use ($collectCounts) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'store_id' => $product->store_id,
            'price' => $product->price,
            'description' => $product->description,
            'collect_count' => $collectCounts->get($product->id, 0),
        ];
        })->sortByDesc('collect_count')->values();


        // 輸出結果
        return response()->json($results);
    }
}
