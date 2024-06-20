<?php

namespace App\Http\Controllers;

use App\Models\Lock;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class LockController extends Controller
{

    public function checklock($private_id)
    {
        $lock = Lock::where('private_id',$private_id)
            ->get();
        foreach($lock as $l){
            if($l -> count == 5 and $l -> status == 0){
                $l -> status = 1 ;
                $l -> count = 0 ;
                $l -> save();
                return true;
            }
            else if ($l -> status == 1){
                return true;
            }
            return false;
        }
    }

    public function emptyRecord($private_id)
    {
        $lock = Lock::where('private_id',$private_id)
            ->get();
        foreach($lock as $l){
            $l -> status = 0 ;
            $l -> count = 0;
            $l -> save();
        }
        return;
    }

    public function incrementCount($private_id)
    {
        $lock = Lock::where('private_id',$private_id)
            ->get();
        foreach($lock as $l){
            $l -> count = $l -> count + 1;
            $l -> save();
        }
        return;
    }
}
