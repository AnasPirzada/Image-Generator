<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'postTitle' => 'required|string',
            'postDescription' => 'required|string',
            'fileInput' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'language' => 'required|string',
            'photoDivId' => 'required|string',
        ]);

        if ($request->hasFile('fileInput')) {
            $file = $request->file('fileInput');
            $filePath = $file->store('uploads', 'public');
        } else {
            $filePath = null;
        }

        //Converting the base64 into png over here
        $base64Image = $validatedData['photoDivId'];
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        $pngFilePath = public_path('storage/screen/') . uniqid() . '.png';

        file_put_contents($pngFilePath, $imageData);

        $post = Post::create([
            'title' => $validatedData['postTitle'],
            'description' => $validatedData['postDescription'],
            'file_path' => $filePath,
            'translated_title' => $request->input('imageTitle'),
            'translated_description' => $request->input('imageDescription'),
            // 'photo_div_id' => $validatedData['photoDivId'],
            // 'photo_div_id' => $pngFilePath,
            'photo_div_id' => 'storage/screen/' . basename($pngFilePath), // Store the relative path
        ]);
    }
}
