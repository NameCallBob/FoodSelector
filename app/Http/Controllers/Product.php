<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class ProductController extends Controller
{
    // Create new product
    public function create(Request $request)
    {
        $this->validate($request, [
            'product_cate_id' => 'required|exists:product_cates,id',
            'store_id' => 'required|exists:store,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'picUrl' => 'required|string',
        ]);

        $product = new Product();
        $product->product_cate_id = $request->input('product_cate_id');
        $product->store_id = $request->input('store_id');
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->picUrl = $request->input('picUrl');
        $product->save();

        return response()->json($product, 201);
    }

    // Read single product by ID
    public function read($product_id)
    {
        $product = Product::findOrFail($product_id);
        return response()->json($product);
    }

    public function store_data($store_id){
        $product = Product::where(
            'store_id',$store_id);
        return response()->json($product);
    }

    // Read products with conditions
    public function readByConditions(Request $request)
    {
        $query = Product::query();

        if ($request->has('product_cate_id')) {
            $query->where('product_cate_id', $request->input('product_cate_id'));
        }

        if ($request->has('store_id')) {
            $query->where('store_id', $request->input('store_id'));
        }

        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        $result = $query->get();
        return response()->json($result);
    }

    // Update product by ID
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_cate_id' => 'required|exists:product_cates,id',
            'store_id' => 'required|exists:store,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'picUrl' => 'required|string',
        ]);

        $product = Product::findOrFail($id);
        $product->product_cate_id = $request->input('product_cate_id');
        $product->store_id = $request->input('store_id');
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->picUrl = $request->input('picUrl');
        $product->save();

        return response()->json($product);
    }

    // Delete product by ID
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
