<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class CommentController extends Controller
{
    // Create new comment
    public function create(Request $request)
    {
        $this->validate($request, [
            'store_id' => 'required|exists:store,id',
            'star' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->store_id = $request->input('store_id');
        $comment->star = $request->input('star');
        $comment->comment = $request->input('comment');
        $comment->save();

        return response()->json($comment, 201);
    }

    // Read single comment by ID
    public function read($id)
    {
        $comment = Comment::findOrFail($id);
        return response()->json($comment);
    }

    // Read comments with conditions
    public function readByConditions(Request $request)
    {
        $query = Comment::query();

        if ($request->has('store_id')) {
            $query->where('store_id', $request->input('store_id'));
        }

        if ($request->has('star')) {
            $query->where('star', $request->input('star'));
        }

        if ($request->has('comment')) {
            $query->where('comment', 'LIKE', '%' . $request->input('comment') . '%');
        }

        $result = $query->get();
        return response()->json($result);
    }

    // Update comment by ID
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'store_id' => 'required|exists:store,id',
            'star' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->store_id = $request->input('store_id');
        $comment->star = $request->input('star');
        $comment->comment = $request->input('comment');
        $comment->save();

        return response()->json($comment);
    }

    // Delete comment by ID
    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
