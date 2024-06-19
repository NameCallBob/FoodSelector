<?php

namespace App\Http\Controllers;

use App\Models\PrivateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller;

class PrivateController extends Controller
{
    // Create new record
    public function create(Request $request)
    {
        $this->validate($request, [
            'account' => 'required|unique:private|max:255',
            'password' => 'required',
        ]);

        $private = new PrivateModel();
        $private->account = $request->input('account');
        $private->password = Hash::make($request->input('password'));
        $private->save();

        return response()->json($private, 201);
    }

    // Read single record by ID
    public function read($id)
    {
        $private = PrivateModel::findOrFail($id);
        return response()->json($private);
    }

    // Read records with conditions
    public function readByConditions(Request $request)
    {
        $query = PrivateModel::query();

        if ($request->has('account')) {
            $query->where('account', $request->input('account'));
        }

        $result = $query->get();
        return response()->json($result);
    }

    // Update record by ID
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'account' => 'required|max:255|unique:private,account,' . $id,
            'password' => 'required',
        ]);

        $private = PrivateModel::findOrFail($id);
        $private->account = $request->input('account');
        $private->password = Hash::make($request->input('password'));
        $private->save();

        return response()->json($private);
    }

    // Delete record by ID
    public function delete($id)
    {
        $private = PrivateModel::findOrFail($id);
        $private->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
