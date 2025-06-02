<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();

        SEOMeta::setTitle($post->title . ' - Shiela Blog');
        SEOMeta::setDescription(Str::limit(strip_tags($post->content), 160));

        OpenGraph::setTitle($post->title);
        OpenGraph::setDescription(Str::limit(strip_tags($post->content), 160));
        OpenGraph::addImage($post->featured_image ? asset('storage/' . $post->featured_image) : asset('images/default-blog.jpg'));

        return view('blog.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
