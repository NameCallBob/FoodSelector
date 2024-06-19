<?php

namespace App\Http\Controllers;

use App\Models\Look;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Laravel\Lumen\Routing\Controller;

class LookController extends Controller
{
    // Create new look record
    public function create(Request $request)
    {
        $this->validate($request, [
            'store_id' => 'required|exists:store,id',
        ]);

        $look = Look::firstOrCreate(
            ['store_id' => $request->input('store_id'), 'date' => Carbon::now()->toDateString()],
            ['count' => 0]
        );

        $look->count += 1;
        $look->save();

        return response()->json($look, 201);
    }

    // Read single look record by ID
    public function read($id)
    {
        $look = Look::findOrFail($id);
        return response()->json($look);
    }

    // Read look records with conditions
    public function readByConditions(Request $request)
    {
        $query = Look::query();

        if ($request->has('store_id')) {
            $query->where('store_id', $request->input('store_id'));
        }

        if ($request->has('date')) {
            $query->where('date', $request->input('date'));
        }

        $result = $query->get();
        return response()->json($result);
    }

    // Update look record by ID
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'store_id' => 'required|exists:store,id',
            'date' => 'required|date',
            'count' => 'required|integer',
        ]);

        $look = Look::findOrFail($id);
        $look->store_id = $request->input('store_id');
        $look->date = $request->input('date');
        $look->count = $request->input('count');
        $look->save();

        return response()->json($look);
    }

    // Delete look record by ID
    public function delete($id)
    {
        $look = Look::findOrFail($id);
        $look->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
