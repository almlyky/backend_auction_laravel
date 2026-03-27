<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Container\Attributes\Storage;
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
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'data' => 'required|array',
            'data.name' => 'required|string|max:255',
            'data.description' => 'nullable|string',
            'data.price' => 'required|numeric',
            'data.user_id' => 'required|integer|exists:users,id',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()
            ], 422);
        }
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
    public function showPostByUser($userId)
    {
        //
        try {
            $post = Post::where('user_id', $userId)->get();
            return response()->json(['data' => $post]);
        } catch (\Exception $e) {
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
    public function update(Request $request, $postId)
    {
        try {
            $input = $request->all();

            $post = Post::findOrFail($postId);

            // تحديث بيانات البوست (بدون الصور)
            $post->update($input['data']);

            // معالجة الصور المحذوفة
            $deletedImages = $request->input('deleted_images_ids', []);

            // في حال وصلت كنص JSON من Flutter
            if (is_string($deletedImages)) {
                $deletedImages = json_decode($deletedImages, true) ?? [];
            }

            if (!empty($deletedImages)) {
                $images = PostImage::whereIn('id', $deletedImages)->get();

                foreach ($images as $image) {
                    if ($image->image_url && file_exists(public_path($image->image_url))) {
                        unlink(public_path($image->image_url));
                    }
                }

                PostImage::whereIn('id', $deletedImages)->delete();
            }

            // إضافة صور جديدة
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {

                    $name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('postImages'), $name);

                    PostImage::create([
                        'post_id' => $post->id,
                        'image_url' => 'postImages/' . $name,
                    ]);
                }
            }
            $updatedPost = Post::find($postId);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الإعلان بنجاح',
                'data' => $updatedPost,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
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

    public function markSold($id)
    {
        $post = Post::findOrFail($id);

        if ($post->status == 'sold') {
            return response()->json(['success' => false, 'message' => 'الإعلان بالفعل تم بيعه'], 400);
        }

        $post->update([
            'status' => 'sold',
            'sold_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'تم وضع الإعلان كـ تم البيع', 'post' => $post]);
    }
}
