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

    public function getCollect($id){
        // 取得今天的日期
        $today = Carbon::now()->toDateString();
        
        $allcounts = $this -> whereIn('products_id', $id)
                    ->select('products_id', DB::raw('COUNT(*) as count'))
                    ->groupBy('products_id')
                    ->get();

        $daycount = $this -> whereIn('products_id', $id)
                    ->where("created_at",$today)
                    ->select('products_id', DB::raw('COUNT(*) as count'))
                    ->groupBy('products_id')
                    ->get();

        $all_all = 0;
        $all_day = 0;
        foreach ($allcounts as $count) {
            $all_all = $all_all + $count->count;
        }
        foreach ($daycount as $count) {
            $all_day = $all_day + $count->count;
        }

        return [$all_day,$all_all];
    }
}
