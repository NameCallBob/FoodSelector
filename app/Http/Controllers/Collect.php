<?php

namespace App\Http\Controllers;

use App\Models\Collect;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class CollectController extends Controller
{
    // Create new collect
    public function create(Request $request)
    {
        $this->validate($request, [
            'member_id' => 'required|exists:members,id',
            'products_id' => 'required|exists:products,id',
        ]);

        $collect = new Collect();
        $collect->member_id = $request->input('member_id');
        $collect->products_id = $request->input('products_id');
        $collect->save();

        return response()->json($collect, 201);
    }

    // Read single collect by ID
    public function read($id)
    {
        $collect = Collect::findOrFail($id);
        return response()->json($collect);
    }

    // Read collects with conditions
    public function readByConditions(Request $request)
    {
        $query = Collect::query();

        if ($request->has('member_id')) {
            $query->where('member_id', $request->input('member_id'));
        }

        if ($request->has('products_id')) {
            $query->where('products_id', $request->input('products_id'));
        }

        $result = $query->get();
        return response()->json($result);
    }

    // Update collect by ID
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'member_id' => 'required|exists:members,id',
            'products_id' => 'required|exists:products,id',
        ]);

        $collect = Collect::findOrFail($id);
        $collect->member_id = $request->input('member_id');
        $collect->products_id = $request->input('products_id');
        $collect->save();

        return response()->json($collect);
    }

    // Delete collect by ID
    public function delete($id)
    {
        $collect = Collect::findOrFail($id);
        $collect->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
