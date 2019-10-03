<?php

namespace App\Http\Controllers\API\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\Post\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\PostIndexResource;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $posts = $post->withScopes($post->scopes())->latestOrder()->isLive()->paginate(10);

        return (PostIndexResource::collection($posts))
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $this->authorize('create', Post::class);

        $post = Post::create($request->all());

        return (new PostResource($post))
        ->response()
        ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return (new PostResource($post))
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        $post->update($request->all());

        return (new PostResource(
          $post->load([
          'post_category','user'
          ])
        ))
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {

        if ($post->trashed()) {
            $this->authorize('forceDelete', $post);
            $post->forceDelete();

            return (new PostIndexResource($post))
            ->response()
            ->setStatusCode(200);
        }

        $this->authorize('delete', $post);

        $post->delete();

        return (new PostIndexResource($post))
        ->response()
        ->setStatusCode(200);
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
            return (new PostIndexResource($post))
            ->response()
            ->setStatusCode(200);
        }
    }
}
