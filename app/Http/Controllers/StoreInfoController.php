<?php

namespace App\Http\Controllers;
// Look need
use App\Models\Collect;
use App\Models\Look;
//
use App\Models\StoreInfo;
use Exception;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Http\Controllers\AuthController;
use App\Models\PrivateModel;
class StoreInfoController extends Controller
{
    // Create new store info
    public function create(Request $request)
    {
        $this->validate($request, [
            'store_id' => 'required|unique:store_infos|exists:store,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'intro' => 'required|string',
            'tag' => 'required|string',
            'picUrl' => 'required|string|max:255',
        ]);

        $storeInfo = new StoreInfo();
        $storeInfo->store_id = $request->input('store_id');
        $storeInfo->name = $request->input('name');
        $storeInfo->address = $request->input('address');
        $storeInfo->intro = $request->input('intro');
        $storeInfo->tag = $request->input('tag');
        $storeInfo->picUrl = $request->input('picUrl');
        $storeInfo->save();

        return response()->json($storeInfo, 201);
    }

    // Read single store info by ID
    public function read($id)
    {
        $storeInfo = StoreInfo::findOrFail($id);
        Look::addLook($id);
        return response()->json($storeInfo);
    }
    public function all(){
        $storeInfo = StoreInfo::all();
        return response()->json($storeInfo);
    }
    // Read store infos with conditions
    public function readByConditions(Request $request)
    {
        $query = StoreInfo::query();

        if ($request->has('name')) {
            $query->where('name', $request->input('name'));
        }

        if ($request->has('address')) {
            $query->where('address', $request->input('address'));
        }

        if ($request->has('tag')) {
            $query->where('tag', 'LIKE', '%' . $request->input('tag') . '%');
        }

        $result = $query->get();
        return response()->json($result);
    }

    // Update store info by ID
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'store_id' => 'required|exists:store,id|unique:store_infos,store_id,' . $id,
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'intro' => 'required|string',
            'tag' => 'required|string',
            'picUrl' => 'required|string|max:255',
        ]);

        $storeInfo = StoreInfo::findOrFail($id);
        $storeInfo->store_id = $request->input('store_id');
        $storeInfo->name = $request->input('name');
        $storeInfo->address = $request->input('address');
        $storeInfo->intro = $request->input('intro');
        $storeInfo->tag = $request->input('tag');
        $storeInfo->picUrl = $request->input('picUrl');
        $storeInfo->save();

        return response()->json($storeInfo);
    }

    // Delete store info by ID
    public function delete($id)
    {
        $storeInfo = StoreInfo::findOrFail($id);
        $storeInfo->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    //要TOKEN驗證
    public function verify_info(Request $request){
        $ob = new AuthController();
        $id = $ob -> getPayload($request)[0];
        try{
            $private = PrivateModel::with('store.info')->find($id);
            if ($private && $private->store && $private->store->info) {
                $storeInfo = $private->store->info;
                return response()->json($storeInfo);
            } else {
                return response() -> setStatusCode(404,'no data');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // 捕獲到 ModelNotFoundException 代表找不到指定的 PrivateModel
            return response()->json(['error' => 'User not found.'], 404);
        } catch (Exception $e) {
            // 捕獲到其他例外情況，返回 400 Bad Request
            return response()->json(['error' => 'Bad request.'], 400);
        }

    }

    public function getlookAndCollect(Request $request){
        $ob = new AuthController();
        $id = $ob -> getPayload($request)[0];

        try{
            $private = PrivateModel::find($id);

            if ($private) {
                // 取得關聯的 store 的 id
                try{
                    $storeId = $private->store->id;
                    $productIds = $private->store->products()->pluck('id')->toArray();
                }catch(Exception $e){
                    return response() -> json(['message' => 'NoData'])->setStatusCode(404);
                }
                // 使用 $storeId 做你需要的操作
                $look_data = Look::getLook($storeId);
                $collect_data = Collect::getCollect($productIds);
                return response()->json(
                    [
                        'day_collect' => $collect_data[0],
                        'all_collect' => $collect_data[1],
                        'day_look' => $look_data[0],
                        'week_look' => $look_data[1],
                    ]
                );
            }

        }catch(Exception $e){
            return response()->setStatusCode(400,"NoStoreData");
        }
    }
}
