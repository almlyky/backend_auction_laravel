<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\User;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        // Get all users blocked by the current authenticated user
        $blocks = Block::with('blocked')->where('blocked_by', auth()->id())->get();
        return response()->json($blocks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        if ($request->user_id == auth()->id()) {
            return response()->json(['error' => 'You cannot block yourself.'], 422);
        }

        $existingBlock = Block::where('blocked_by', auth()->id())
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingBlock) {
            return response()->json(['message' => 'User is already blocked.'], 200);
        }

        $block = Block::create([
            'blocked_by' => auth()->id(),
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'message' => 'User blocked successfully.',
            'block' => $block
        ], 201);
    }

    public function destroy($id)
    {
        $block = Block::where('blocked_by', auth()->id())
            ->where('user_id', $id)
            ->first();

        if (!$block) {
            return response()->json(['error' => 'Block not found.'], 404);
        }

        $block->delete();

        return response()->json(['message' => 'User unblocked successfully.']);
    }
}
