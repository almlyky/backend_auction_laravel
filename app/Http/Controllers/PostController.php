<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $post = Post::all();
            return response()->json(["success" => true, "data" => $post], 200);
        } catch (\Exception $e) {
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
        $input = $request->all();
        try {
            $post = Post::create($input['data']);
            if ($request->hasFile('images')) {
                foreach ($request->file(('images')) as $image) {
                    $file = $image;
                    // $imagename = $file->getClientOriginalName() . $file->getExtension();
                    $extension = $file->getClientOriginalExtension(); // يمتد عبر المسار الأصلي بدون نقطة
                    $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // الاسم فقط بدون امتداد

                    // $imagename = $filename . '_' . time() . '.' . $extension;
                    $imagename = $filename  . '.' . $extension;

                    $file->move(public_path('postImages'), $imagename);
                    $path = 'postImages/' . $imagename;
                    // $post->postImages()->create([
                    //     'image_path' => $imagename
                    // ]);
                    PostImage::create([
                        'post_id' => $post->id,
                        'image_url' => $path
                    ]);
                    // $imagename = time().'_'.$image->getClientOriginalName();
                    // $image->move(public_path('postImages'),$imagename);
                    // $post->postImages()->create([
                    //     'image_path'=>$imagename
                    // ]);
                }
            }
            // $post->load('postImages');

            return response()->json(['success' => true, 'message' => 'تم اضافة الاعلان بنجاح', 'data' => $post], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'input' => $input], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        try {
            return response()->json(["success" => true, "data" => $post], 200);
        } catch (\Exception $e) {
            return response()->json(["success" => false, "error" => $e->getMessage()], 404);
        }
    }
    public function showPostByUser( $userId)
    {
        //
        try{
            $post=Post::where('user_id',$userId)->get();
            return response()->json(['data'=>$post]);
        }
        catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
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
        try {
            $post->delete();
            return response()->json(["success" => true, "message" => "تم حذف الاعلان بنجاح"], 200);
        } catch (\Exception $e) {
            return response()->json(["success" => false, "error" => $e->getMessage()], 404);
        }
    }
}
