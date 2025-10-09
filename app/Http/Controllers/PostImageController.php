<?php

namespace App\Http\Controllers;

use App\Models\PostImage;
use Illuminate\Http\Request;

class PostImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if (!$request->hasFile('post_image')) {
                return response()->json(['success' => false, 'message' => 'No image file uploaded'], 400);
            }
            $file = $request->file('post_image');
            $imagename = $file->getClientOriginalName().$file->getExtension();
            // if(file_exists($imagename))
            $file->move(public_path('postImages'),$imagename);
            return response()->json(['success'=>true,'message'=>'successfuly add image'],201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error'=>$e->getMessage(),500]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PostImage $postImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostImage $postImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PostImage $postImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostImage $postImage)
    {
        //
    }
}
