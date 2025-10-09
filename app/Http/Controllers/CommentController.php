<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
        $users=Comment::all();
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
        try{
            $input=$request->all();
            Comment::create($input);
            return response()->json(['success'=>true,'message'=>'successfuly add comments']);
        }
        catch(\Exception $e){
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
         try{
        return response()->json(["success"=>true,"data"=>$comment],200);
        }
        catch(\Exception $e){
        return response()->json(["success"=>false,"error"=>$e->getMessage()],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
