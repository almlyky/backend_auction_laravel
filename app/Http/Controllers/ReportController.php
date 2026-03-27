<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        try {
        $validator = Validator::make($request->all(), [
            'reported_user_id' => 'nullable|exists:users,id',
            'reported_post_id' => 'nullable|exists:posts,id',
            'reason' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if (!$request->reported_user_id && !$request->reported_post_id) {
            return response()->json(['error' => 'You must report either a user or a post.'], 422);
        }

        $report = Report::create([
            'reporter_id' => auth('api')->id(),
            'reported_user_id' => $request->reported_user_id,
            'reported_post_id' => $request->reported_post_id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Report submitted successfully.',
            'report' => $report
        ], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while submitting the report: ' . $e->getMessage()], 500);
    }
    }
}
