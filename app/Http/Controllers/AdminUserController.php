<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount(['receivedReports', 'posts']);

        // Optional search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
        }

        $users = $query->latest()->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with([
            'receivedReports' => function($q) {
                $q->latest();
            },
            'receivedReports.reporter',
            'blocksReceived.blocker',
            'posts' => function($q) {
                $q->latest()->limit(5); // Show latest 5 posts as preview
            }
        ])
        ->withCount(['receivedReports', 'posts', 'blocksReceived'])
        ->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }
}
