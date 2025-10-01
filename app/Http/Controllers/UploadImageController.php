<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        $images = $images->map(function($image) {
            $image->path = Storage::url($image->path);
            return $image;
        });
        return response()->json([
            'images' => $images,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
        ]);
        $file = $request->file('image');
        $path = $file->storePublicly('images',['disk' => config('filesystems.default')]);
        Storage::disk(config('filesystems.default'))->setVisibility($path, 'public');
        Image::create([
            'name' => $request->name,
            'path' => $path,
        ]);
        return response()->json([
            'message' => 'Image uploaded successfully',
            'image' => $path,
        ]);
    }

    public function destroy(Image $image)
    {
        Storage::disk(config('filesystems.default'))->delete($image->path);
        $image->delete();
        return response()->json([
            'message' => 'Image deleted successfully',
        ]);
    }


}
