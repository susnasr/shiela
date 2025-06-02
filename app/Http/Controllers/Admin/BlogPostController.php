<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('category', 'author')->latest()->get();
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        $post = new BlogPost();
        $post->title = $validated['title'];
        $post->slug = Str::slug($validated['title']);
        $post->content = $validated['content'];
        $post->excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 200);
        $post->category_id = $validated['category_id'];
        $post->user_id = Auth::id();
        $post->is_published = $request->has('is_published');
        $post->published_at = $request->has('is_published') ? now() : null;

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('blog-images', 'public');
        }

        $post->save();

        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully.');
    }

    public function show(BlogPost $blog)
    {
        $post = $blog->load('category', 'author');
        return view('admin.blog.show', compact('post'));
    }

    public function edit(BlogPost $blog)
    {
        $categories = BlogCategory::all();
        $post = $blog;
        return view('admin.blog.edit', compact('post', 'categories'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        $blog->title = $validated['title'];
        $blog->slug = Str::slug($validated['title']);
        $blog->content = $validated['content'];
        $blog->excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 200);
        $blog->category_id = $validated['category_id'];
        $blog->is_published = $request->has('is_published');
        $blog->published_at = $request->has('is_published') ? now() : null;

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $blog->image = $request->file('image')->store('blog-images', 'public');
        }

        $blog->save();

        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully.');
    }
}
