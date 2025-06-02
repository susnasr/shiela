<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('BlogController::index called');
        $posts = BlogPost::where('is_published', true)->with('category')->latest()->get();
        Log::info('Posts retrieved', ['count' => $posts->count(), 'posts' => $posts->toArray()]);

        SEOMeta::setTitle('Shiela Blog');
        SEOMeta::setDescription('Explore the latest blog posts on Shiela Blog, covering various topics and insights.');
        OpenGraph::setTitle('Shiela Blog');
        OpenGraph::setDescription('Explore the latest blog posts on Shiela Blog, covering various topics and insights.');

        return view('blog.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->where('is_published', true)->with('category')->firstOrFail();
        Log::info('Post retrieved', ['slug' => $slug, 'post' => $post->toArray()]);

        SEOMeta::setTitle($post->title . ' - Shiela Blog');
        SEOMeta::setDescription(Str::limit(strip_tags($post->content), 160));

        OpenGraph::setTitle($post->title);
        OpenGraph::setDescription(Str::limit(strip_tags($post->content), 160));
        OpenGraph::addImage($post->featured_image ? asset('storage/' . $post->featured_image) : asset('images/default-blog.jpg'));

        return view('blog.show', compact('post'));
    }

    // Other methods (create, store, edit, update, destroy) can remain empty if handled by BlogPostController
}
