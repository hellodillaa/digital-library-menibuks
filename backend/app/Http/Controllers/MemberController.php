<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return response()->json($members, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_code' => 'required|string|unique:members',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:members',
            'phone'       => 'nullable|string',
            'address'     => 'nullable|string',
        ]);

        $member = Member::create($request->all());
        return response()->json($member, 201);
    }

    public function show($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        return response()->json($member, 200);
    }

    public function update(Request $request, $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        $member->update($request->all());
        return response()->json($member, 200);
    }

    public function destroy($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        $member->delete();
        return response()->json(['message' => 'Anggota berhasil dihapus'], 200);
    }
}