<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $pendingReportsCount = Report::where('status', 'pending')->count();
        $usersCount = User::count();
        
        return view('admin.dashboard', compact('pendingReportsCount', 'usersCount'));
    }

    public function reports()
    {
        $pendingReports = Report::with(['reporter', 'reportedUser', 'reportedPost'])->where('status', 'pending')->latest()->get();
        $reviewedReports = Report::with(['reporter', 'reportedUser', 'reportedPost'])->where('status', 'reviewed')->latest()->get();
        $rejectedReports = Report::with(['reporter', 'reportedUser', 'reportedPost'])->where('status', 'rejected')->latest()->get();
        
        return view('admin.reports.index', compact('pendingReports', 'reviewedReports', 'rejectedReports'));
    }

    public function reportDetails($id)
    {
        $report = Report::with(['reporter', 'reportedUser', 'reportedPost'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    public function updateReportStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,rejected',
            'admin_notes' => 'nullable|string'
        ]);

        $report = Report::findOrFail($id);
        $report->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->back()->with('success', 'Report status updated successfully.');
    }

    public function toggleUserBlock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        $action = $user->is_blocked ? 'blocked' : 'unblocked';
        return redirect()->back()->with('success', "User has been {$action} successfully.");
    }

    public function postDetails($id)
    {
        $post = \App\Models\Post::with(['user', 'category'])->findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    public function deletePost($id)
    {
        $post = \App\Models\Post::findOrFail($id);
        $post->delete(); // Uses SoftDeletes based on the model
        
        return redirect()->back()->with('success', 'تم حذف الإعلان بنجاح.');
    }
}
