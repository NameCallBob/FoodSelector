<?php

namespace App\Http\Controllers;

use App\Models\ProductCate;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class ProductCateController extends Controller
{
    // Create new product category
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $productCate = new ProductCate();
        $productCate->name = $request->input('name');
        $productCate->save();

        return response()->json($productCate, 201);
    }

    // Read single product category by ID
    public function all()
    {
        $productCate = ProductCate::all();
        return response()->json($productCate);
    }

    // Read product categories with conditions
    public function readByConditions(Request $request)
    {
        $query = ProductCate::query();

        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        $result = $query->get();
        return response()->json($result);
    }

    // Update product category by ID
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $productCate = ProductCate::findOrFail($id);
        $productCate->name = $request->input('name');
        $productCate->save();

        return response()->json($productCate);
    }

    // Delete product category by ID
    public function delete($id)
    {
        $productCate = ProductCate::findOrFail($id);
        $productCate->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
