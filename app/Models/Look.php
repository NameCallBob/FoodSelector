<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// log
use Illuminate\Support\Facades\Log;


class Look extends Model
{
    protected $table = 'look';

    protected $fillable = [
        'store_id', 'date', 'count',
    ];

    /**
     * 取得瀏覽次數
     */
    public static function getLook($storeId)
    {
        // 取得今天的日期
        $today = Carbon::now()->toDateString();

        // 取得過去7天的日期範圍
        $past7days = Carbon::now()->subDays(7)->toDateString();

        // 查詢今天的瀏覽次數
        $todayViewCount = self::where("store_id", $storeId)
                        ->where("date", $today)
                        ->count();

        // 查詢過去7天的總瀏覽次數
        $allViewCounts = self::whereBetween('date', [$past7days, $today])
                        ->where("store_id", $storeId)
                        ->sum('count');

        return [$todayViewCount, $allViewCounts];
    }
    /**
     * 瀏覽次數+=1
     */
    public static function addLook($store_id)
    {
        $today = Carbon::today();
        try {
            // 查詢今天的記錄是否存在
            $dailyCount = self::where('date', $today)
                ->where('store_id', $store_id)
                ->first();

            if ($dailyCount) {
                // 如果找到了今天的記錄，將 count 加一
                $dailyCount->count += 1;
                $dailyCount->save();
            } else {
                // 如果沒有找到今天的記錄，則新增一筆新的記錄
                $dailyCount = new self();
                $dailyCount->date = $today;
                $dailyCount->store_id = $store_id;
                $dailyCount->count = 1;
                $dailyCount->save();
            }
            return true;
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }
}
