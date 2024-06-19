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
}
