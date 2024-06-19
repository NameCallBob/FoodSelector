<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class MemberController extends Controller
{
    // Create new member
    public function create(Request $request)
    {
        $this->validate($request, [
            'private_id' => 'required|unique:members|exists:private,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:members|string|max:255',
            'birth' => 'required|date',
            'safe_ques1' => 'required|integer',
            'safe_ques2' => 'required|integer',
            'safe_ans1' => 'required|string',
            'safe_ans2' => 'required|string',
        ]);

        $member = new Member();
        $member->private_id = $request->input('private_id');
        $member->name = $request->input('name');
        $member->phone = $request->input('phone');
        $member->birth = $request->input('birth');
        $member->safe_ques1 = $request->input('safe_ques1');
        $member->safe_ques2 = $request->input('safe_ques2');
        $member->safe_ans1 = $request->input('safe_ans1');
        $member->safe_ans2 = $request->input('safe_ans2');
        $member->save();

        return response()->json($member, 201);
    }

    // Read single member by ID
    public function read($id)
    {
        $member = Member::findOrFail($id);
        return response()->json($member);
    }

    // Read members with conditions
    public function readByConditions(Request $request)
    {
        $query = Member::query();

        if ($request->has('name')) {
            $query->where('name', $request->input('name'));
        }

        if ($request->has('phone')) {
            $query->where('phone', $request->input('phone'));
        }

        $result = $query->get();
        return response()->json($result);
    }

    // Update member by ID
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'private_id' => 'required|exists:private,id|unique:members,private_id,' . $id,
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:members,phone,' . $id,
            'birth' => 'required|date',
            'safe_ques1' => 'required|integer',
            'safe_ques2' => 'required|integer',
            'safe_ans1' => 'required|string',
            'safe_ans2' => 'required|string',
        ]);

        $member = Member::findOrFail($id);
        $member->private_id = $request->input('private_id');
        $member->name = $request->input('name');
        $member->phone = $request->input('phone');
        $member->birth = $request->input('birth');
        $member->safe_ques1 = $request->input('safe_ques1');
        $member->safe_ques2 = $request->input('safe_ques2');
        $member->safe_ans1 = $request->input('safe_ans1');
        $member->safe_ans2 = $request->input('safe_ans2');
        $member->save();

        return response()->json($member);
    }

    // Delete member by ID
    public function delete($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
