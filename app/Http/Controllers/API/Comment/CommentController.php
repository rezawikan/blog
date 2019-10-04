<?php

namespace App\Http\Controllers\API\Comment;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\Comment\CommentCreate;
use App\Http\Requests\Comment\CommentUpdate;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Comment $comments)
    {
        $page = $request->page ? $request->page : 12;
        $comments = $comments->latest()
        ->isApproved($request->approved)
        ->paginate($page);

        return (CommentResource::collection($comments))
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
    public function store(CommentCreate $request)
    {
        $this->authorize('create', Comment::class);

        $post = Post::find($request->post_id);

        $comment = $post->comments()->create([
          'body' => $request->body,
          'approved' => true,
          'parent_id' => $request->parent_id,
          'user_id' => $request->user_id
        ]);

        return (new CommentResource($comment))
        ->response()
        ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        $comment->load([
          'user',
          'children.children'
        ]);

        return (new CommentResource($comment))
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
    public function update(CommentUpdate $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment = $comment->update($request->all());

        return (new CommentResource($comment))
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if ($comment->trashed()) {
            $this->authorize('forceDelete', $comment);
            $comment->forceDelete();

            return (new CommentResource($comment))
            ->response()
            ->setStatusCode(200);
        }

        $this->authorize('delete', $comment);

        $comment->delete();

        return (new CommentResource($comment))
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, Comment $comment)
    {
        $this->authorize('restore', $comment);

        if ($comment->trashed()) {
            $comment->restore();
            return (new CommentResource($comment))
            ->response()
            ->setStatusCode(200);
        }
    }
}
