<?php

namespace App\Http\Controllers;

use App\Models\StoreInfo;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
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
}
