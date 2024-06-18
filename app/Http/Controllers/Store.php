<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class StoreController extends Controller
{
    // Create new store
    public function create(Request $request)
    {
        $this->validate($request, [
            'private_id' => 'required|unique:stores|exists:private,id',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'owner_name' => 'required|string|max:255',
        ]);

        $store = new Store();
        $store->private_id = $request->input('private_id');
        $store->phone = $request->input('phone');
        $store->email = $request->input('email');
        $store->owner_name = $request->input('owner_name');
        $store->save();

        return response()->json($store, 201);
    }

    // Read single store by ID
    public function read($id)
    {
        $store = Store::findOrFail($id);
        return response()->json($store);
    }

    // Read stores with conditions
    public function readByConditions(Request $request)
    {
        $query = Store::query();

        if ($request->has('phone')) {
            $query->where('phone', $request->input('phone'));
        }

        if ($request->has('email')) {
            $query->where('email', $request->input('email'));
        }

        if ($request->has('owner_name')) {
            $query->where('owner_name', $request->input('owner_name'));
        }

        $result = $query->get();
        return response()->json($result);
    }

    // Update store by ID
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'private_id' => 'required|exists:private,id|unique:stores,private_id,' . $id,
            'phone' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'owner_name' => 'required|string|max:255',
        ]);

        $store = Store::findOrFail($id);
        $store->private_id = $request->input('private_id');
        $store->phone = $request->input('phone');
        $store->email = $request->input('email');
        $store->owner_name = $request->input('owner_name');
        $store->save();

        return response()->json($store);
    }

    // Delete store by ID
    public function delete($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
