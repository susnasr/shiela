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
        \Log::info('Store method started', ['request_data' => $request->all()]);

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'excerpt' => 'nullable|string|max:500',
                'category_id' => 'required|exists:blog_categories,id',
                'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
                'is_published' => 'nullable|in:on',
            ]);

            \Log::info('Validation passed', ['validated_data' => $validated]);

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
                $post->featured_image = $request->file('image')->store('blog-images', 'public'); // Save to featured_image
            }

            \Log::info('About to save post', ['post_data' => $post->toArray()]);

            $post->save();

            \Log::info('Post saved', ['post_id' => $post->id]);

            return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error in store method', ['error' => $e->getMessage()]);
            throw $e;
        }
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
        \Log::info('Update method started', ['request_data' => $request->all()]);

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'excerpt' => 'nullable|string|max:500',
                'category_id' => 'required|exists:blog_categories,id',
                'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
                'is_published' => 'nullable|in:on', // Accept 'on' for checkbox
            ]);

            \Log::info('Validation passed', ['validated_data' => $validated]);

            $blog->title = $validated['title'];
            $blog->slug = Str::slug($validated['title']);
            $blog->content = $validated['content'];
            $blog->excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 200);
            $blog->category_id = $validated['category_id'];
            $blog->is_published = $request->has('is_published');
            $blog->published_at = $request->has('is_published') ? now() : null;

            if ($request->hasFile('image')) {
                \Log::info('Image upload detected', ['file' => $request->file('image')->getClientOriginalName()]);
                if ($blog->featured_image) { // Use featured_image consistently
                    Storage::disk('public')->delete($blog->featured_image);
                }
                $blog->featured_image = $request->file('image')->store('blog-images', 'public');
            }

            \Log::info('About to update post', ['post_data' => $blog->toArray()]);
            $blog->save();

            \Log::info('Post updated', ['post_id' => $blog->id]);

            return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error in update method', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(BlogPost $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully.');
    }
}
