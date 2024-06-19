<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Look extends Model
{
    protected $table = 'look';

    protected $fillable = [
        'store_id', 'date', 'count',
    ];

    /**
     * 取得瀏覽次數
     */
    public function getLook($id){
        // 取得今天的日期
        $today = Carbon::now()->toDateString();

        // 取得過去7天的日期範圍
        $past7days = Carbon::now()->subDays(7)->toDateString();

        // 查詢今天和過去7天的瀏覽次數
        $allviewCounts = $this -> whereBetween('date', [$past7days, $today])
            ->where("store_id",$id)
            ->select(DB::raw('SUM(count) as total_count'))
            ->first();

        $viewCounts = $this -> where("store_id",$id)
            ->where("date",$today)
            ->get();

        return[$viewCounts->count,$allviewCounts];
    }
    /**
     * 瀏覽次數+=1
     */
    public function addLook($store_id){
        $today = Carbon::today();
        try{
        // 查詢今天的記錄是否存在
        $dailyCount = $this -> where('date', $today)
        ->where('store_id', $store_id)
        ->first();

        if ($dailyCount) {
        // 如果找到了今天的記錄，將 count 加一
        $dailyCount->count += 1;
        $dailyCount->save();
        } else {
        // 如果沒有找到今天的記錄，則新增一筆新的記錄
        $dailyCount = $this;
        $dailyCount->date = $today;
        $dailyCount->store_id = $store_id;
        $dailyCount->count = 1;
        $dailyCount->save();
        }
        return true;
        }catch(Exception $e){
            return false;
        }

    }
}
