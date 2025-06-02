<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug the incoming request data
        $input = $request->all();
        if (!isset($input['content'])) {
            return redirect()->back()->withErrors(['error' => 'Content field is missing from the request.'])->withInput();
        }

        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|string|unique:posts,slug',
        ]);

        // Create the post
        try {
            Post::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'slug' => $validated['slug'],
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create post: ' . $e->getMessage()])->withInput();
        }

        return redirect()->route('blog.index')->with('success', 'Post created successfully!');
    }
}
