<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
        $users=Post::all();
        return response()->json(["success"=>true,"data"=>$users],200);
        }
        catch(\Exception $e){
        return response()->json(["success"=>false,"error"=>$e->getMessage()],404);
        }
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
            $input=$request->all();
            Post::create($input);
            // Post::create([
            //     "name" => $request->name,
            //     "address" => $request->address,
            //     "discribtion" => $request->discribtion,
            //     "price" => $request->price,
            //     "status" => $request->status,
            //     "product_status" => $request->product_status,
            //     "user_id" => $request->user_id,
            //     "sub_category_id" => $request->sub_category_id
            // ]);
            return response()->json(['success' => true, 'message' => 'تم اضافة الاعلان بنجاح'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        try{
        return response()->json(["success"=>true,"data"=>$post],200);
        }
        catch(\Exception $e){
        return response()->json(["success"=>false,"error"=>$e->getMessage()],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
