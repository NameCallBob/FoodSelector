
<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // 取得所有項目
    public function index()
    {
        return response()->json(Store::all());
    }

    // 新增項目
    public function store(Request $request)
    {
        $this->validate($request, [
            'private_id' => 'required|exists:private,id|unique:Stores,private_id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'intro' => 'required|string',
            'tag' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'owner_name' => 'required|string|max:255',
        ]);

        $Store = Store::create($request->all());

        return response()->json($Store, 201);
    }
    // 所有店家資料
    public function allstore()
    {

    }
    // 取得單一項目
    public function show($id)
    {
        $Store = Store::select("id","name","address","intro",'tag')->find($id);

        if (is_null($Store)) {
            return response()->json(['message' => 'Store not found'], 404);
        }

        return response()->json($Store);
    }



    // 更新項目
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'private_id' => 'required|exists:private,id|unique:Stores,private_id,' . $id,
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'intro' => 'required|string',
            'tag' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'owner_name' => 'required|string|max:255',
        ]);

        $Store = Store::find($id);

        if (is_null($Store)) {
            return response()->json(['message' => 'Store not found'], 404);
        }

        $Store->update($request->all());

        return response()->json($Store);
    }

    // 刪除項目
    public function destroy($id)
    {
        $Store = Store::find($id);

        if (is_null($Store)) {
            return response()->json(['message' => 'Store not found'], 404);
        }

        $Store->delete();

        return response()->json(['message' => 'Store deleted successfully']);
    }
}