<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $category=Category::all();
            return response()->json(['success'=>true,'data'=>$category],200);
        }
        catch(\Exception $e){
            return response()->json(['success'=>false,'error'=>$e->getMessage()]);
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
            Category::create($input);
            return response()-> json(['success'=>true,'message'=>'successfuly add category'],201);
        }
        catch(\Exception $e ){
            return response()->json(['success'=>false,'error'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
         try{
        return response()->json(["success"=>true,"data"=>$category],200);
        }
        catch(\Exception $e){
        return response()->json(["success"=>false,"error"=>$e->getMessage()],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
