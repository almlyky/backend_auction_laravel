<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         try{
            $favorite=Favorite::all();
            return response()->json(['success'=>true,'data'=>$favorite],200);
        }
        catch(\Exception $e){
            return response()->json(["success" => false, "error" => $e->getMessage()], 404); 
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
            $validated = $request->validate([
                'user_id' => 'required|integer',
                'post_id' => 'required|integer',
            ]);

            if (Favorite::where($validated)->exists()) {
                return response()->json(['success' => false, 'message' => 'This favorite already exists'], 409);
            }
            $input=$request->all();
            Favorite::create($input);
            return response()-> json(['success'=>true,'message'=>'successfuly add category'],201);
        }
        catch(\Exception $e ){
            return response()->json(['success'=>false,'error'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        try{
            $favorite=Favorite::with('post')->where('user_id',$userId)->get();
            return response()->json(['success'=>true,'data'=>$favorite],200);
        }
        catch(\Exception $e){
            return response()->json(["success" => false, "error" => $e->getMessage()], 404); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($postId)
    {
        //
        try{
            $favorite=Favorite::where('post_id',$postId);
            if(!$favorite->exists()){
                return response()->json(['success'=>false,'message'=>'favorite not found'],404);
            }
            $favorite->delete();
            return response()->json(['success'=>true,'message'=>'successfuly delete favorite'],200);
        }
        catch(\Exception $e){
            return response()->json(['success'=>false,'error'=>$e->getMessage()],404);
        }
        
    }
}
