<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Post $posts)
    {
        $this->authorize('view', Post::class);

        return view('posts.index', ['posts' => $posts->search($request->q)->withTrashed()->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Post::class);

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        Post::create($request->merge([
          'slug' => $request->name,
          'user_id' => auth()->user()->id,
          'image' => 'jpas'
        ])->all());

        return redirect()->route('post.index')->withStatus(__('Post successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->merge([
          'slug' => $request->name,
          'user_id' => auth()->user()->id,
          'image' => 'jpas'
        ])->all());

        return redirect()->route('post.index')->withStatus(__('Post successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->trashed()) {
            $this->authorize('forceDelete', $post);
            $post->forceDelete();

            return redirect()->route('post.index')->withStatus(__('Post successfully force deleted.'));
        }

        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('post.index')->withStatus(__('Post successfully deleted.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, Post $post)
    {
        $this->authorize('restore', $post);

        if ($post->trashed()) {
            $post->restore();

            return redirect()->route('post.index')->withStatus(__('Post successfully restored.'));
        }
    }
}
