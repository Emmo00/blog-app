<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;

class ImageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        $imagePath = $request->file("image")->store('images', 'public');
        $image = Image::create([
            'path' => $imagePath,
        ]);
        return response()->json([
            'message' => 'Image Saved',
            'status' => true,
            'date' => $image,
        ]);
    }
}
