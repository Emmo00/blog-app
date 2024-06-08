<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Requests\StoreImageRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateImageRequest;

class ImageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        $imagePath = $request->file("file")->store('images', 'public');
        $image = Image::create([
            'path' => $imagePath,
        ]);
        return response()->json([
            'message' => 'Image Saved',
            'status' => true,
            'date' => $image,
            'link' => url('/storage/' . $imagePath),
        ]);
    }

    public function destroy(Image $image, Request $request)
    {
        if ($request->user_id === $image->user_id)
            $image->delete();
    }
}
