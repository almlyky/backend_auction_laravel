<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::all();
            return response()->json(["success" => true, "data" => $users], 200);
        } catch (\Exception $e) {
            return response()->json(["success" => false, "error" => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $expiresAt = now()->addHour();
            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                // 'email'=>$request->email,
                'password' => bcrypt($request->password),
                "verification_token" => str()->random(60),
                "token_expires_at"=>$expiresAt
            ]);
            // $verifyUrl = url('/api/verify/'. $user->verification_token);
            $verifyUrl = "myapp://verify/". $user->verification_token;
            return response()->json(['success' => true, 'message' => 'User Registered Successfully', "verify_url" => $verifyUrl], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        
        // try{
        //     $post=Post::where('user_id',$userId)->get();
        //     return response()->json(['data'=>$post]);
        // }
        // catch (\Exception $e) {
        //     return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        // }
        // return response()->json(['user'=>$user,'password'=>]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
