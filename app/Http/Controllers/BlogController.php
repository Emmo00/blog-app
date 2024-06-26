<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Requests\UpdateBlogPostRequest;
use App\Http\Requests\NewBlogPostRequest;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function explore()
    {
        try {
            $blogs = Blog::orderBy('created_at', 'desc')->paginate(12);
            return response()->json([
                'message' => 'Explore Articles',
                'status' => true,
                'data' => $blogs,
            ]);
        } catch (error) {
            return response()->json([
                'message' => 'Server Error',
                'status' => false,
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $user_blogs = auth()->user()->blogs()->orderBy('created_at', 'desc')->paginate(12);
            return response()->json([
                'message' => 'User Blog Posts',
                'status' => true,
                'data' => $user_blogs,
            ]);
        } catch (error) {
            return response()->json([
                'message' => 'Server Error',
                'status' => false,
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(NewBlogPostRequest $request)
    {
        try {
            $thumbnailPath = cloudinary()->uploadFile($request->file('thumbnail')->getRealPath())->getSecurePath();
            $mainPicturePath = cloudinary()->uploadFile($request->file('main_image')->getRealPath())->getSecurePath();
            $blog = Blog::create([
                'user_id' => request()->user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'thumbnail' => $thumbnailPath,
                'main_image' => $mainPicturePath
            ]);
            return response()->json([
                'message' => 'Blog post created',
                "status" => true,
                "data" => $blog
            ], 201);
        } catch (error) {
            return response()->json([
                'message' => 'server error',
                'status' => false,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json([
            'message' => 'blog',
            "status" => true,
            'data' => $blog
        ]);
    }

    public function update(UpdateBlogPostRequest $request, string $id)
    {
        try {
            $blog = Blog::findOrFail($id);
            if (!($request->user()->id === $blog->user_id)) {
                return response()->json([
                    "message" => 'Unauthorized',
                    'status' => false,
                ], 401);
            }
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = cloudinary()->uploadFile($request->file('thumbnail')->getRealPath())->getSecurePath();
                $blog->thumbnail = $thumbnailPath;
            }
            if ($request->hasFile('main_image')) {
                Storage::delete('public/' . $blog->main_image);
                $mainPicturePath = cloudinary()->uploadFile($request->file('main_image')->getRealPath())->getSecurePath();
                $blog->main_image = $mainPicturePath;
            }

            $blog->update($request->only('title', 'description', 'content'));
            return response()->json([
                'message' => 'Blog post updated',
                'status' => true,
                'data' => $blog
            ]);
        } catch (error) {
            return response()->json([
                'message' => 'Server Error',
                'status' => false,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        if (auth()->user()->id === $blog->user_id) {
            $blog->delete();
            return response()->json([
                'message' => 'Blog deleted',
                'status' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Blog not deleted',
                'status' => true,
                'meta' => auth()->id(),
                'data' => $blog->user()->id
            ]);
        }
    }

    public function recommendations(string $id)
    {
        try {
            $blogs = Blog::where('id', '!=', $id)->orderBy('created_at', 'desc')->take(20)->inRandomOrder()->take(3)->get();

            return response()->json([
                'message' => 'Blog recommendations',
                'status' => true,
                'data' => $blogs
            ]);
        } catch (err) {
            return response()->json([
                'message' => 'Server Error',
                'status' => false,
            ], 500);
        }
    }
}
