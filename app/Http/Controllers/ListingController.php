<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ListingController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::all();

        return view('listing', compact('posts'));
    }
    public function delete(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            // Handle the case where the post does not exist
            return back()->with('error', 'Post not found.');
        }

        // Delete the post
        $post->delete();

        // Return a message indicating success
        return back()->with('success', 'Post deleted successfully.');
    }
}
