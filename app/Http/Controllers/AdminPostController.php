<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = \App\Models\Post::withTrashed()->with(['user'])->withCount('reports')->latest('id')->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function restore($id)
    {
        $post = \App\Models\Post::withTrashed()->findOrFail($id);
        $post->restore();
        
        return redirect()->back()->with('success', 'تم استعادة الإعلان بنجاح.');
    }
}
