<?php

namespace App\Http\Controllers;

use App\Models\Lock;
use Exception;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class LockController extends Controller
{

    public static function checklock($private_id)
    {
        try{
            $lock = Lock::where('private_id',$private_id)
            ->get()->firstOrFail();
            if ($lock -> status === 1){
                return true;
            }
            else if ($lock -> count == 5){
                $lock -> status = 1 ;
                $lock -> count = 0 ;
                $lock -> save();
                return true;
            }
            return false;

        }catch(Exception $e){
            self::add($private_id);
        }
    }

    public static function emptyRecord($private_id)
    {
        $lock = Lock::where('private_id',$private_id)
        ->get()->firstOrFail();

        $lock -> status = 0 ;
        $lock -> count = 0;
        $lock -> save();

        return;
    }

    public static function incrementCount($private_id)
    {
        $lock = Lock::where('private_id',$private_id)
        ->get()->firstOrFail();

        $lock -> count = $lock -> count + 1;
        $lock -> save();

        return;
    }

    public static function add($private_id){
        $ob = new Lock();
        $ob -> private_id = $private_id;
        $ob -> save();
    }
}
