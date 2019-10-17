<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Comment $comments)
    {
        $this->authorize('view', Comment::class);

        return view('comments.index', ['comments' => $comments->search($request->q)->withTrashed()->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Comment::class);

        return view('comments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Comment::class);

        $post = Post::find($request->post_id);

        $post->comments()->save(Comment::make([
          'parent_id' => $request->parent_id,
          'user_id' => auth()->user()->id,
          'body' => $request->body,
          'approved' => true
        ]));

        return redirect()->route('comment.index')->withStatus(__('Comment successfully created.'));
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
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->all());

        return redirect()->route('comment.index')->withStatus(__('Comment successfully updated.'));
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

            if ($comment->children()->count() > 0) {
                $comment->children()->update([
                  'parent_id' => null
                ]);
            }

            $comment->forceDelete();

            return redirect()->route('comment.index')->withStatus(__('Comment successfully force deleted.'));
        }

        $this->authorize('delete', $comment);
        $comment->delete();

        return redirect()->route('comment.index')->withStatus(__('Comment successfully deleted.'));
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

            return redirect()->route('comment.index')->withStatus(__('Comment successfully restored.'));
        }
    }
}
