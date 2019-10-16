<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Tag $tags)
    {
        $this->authorize('view', Tag::class);

        return view('tags.index', ['tags' => $tags->search($request->q)->withTrashed()->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Tag::class);

        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Tag::class);

        Tag::create($request->merge([
          'slug' => $request->name
          ])->all());

        return redirect()->route('tag.index')->withStatus(__('Tag successfully created.'));
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
    public function edit(Tag $tag)
    {
        $this->authorize('update', Tag::class);

        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $this->authorize('update', Tag::class);

        $tag->update($request->merge([
          'slug' => $request->name
          ])->all());

        return redirect()->route('tag.index')->withStatus(__('Tag successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if ($tag->trashed()) {
            $this->authorize('forceDelete', Tag::class);

            $tag->forceDelete();

            return redirect()->route('tag.index')->withStatus(__('Tag successfully force deleted.'));
        }

        $this->authorize('delete', Tag::class);
        $tag->delete();

        return redirect()->route('tag.index')->withStatus(__('Tag successfully deleted.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, Tag $tag)
    {
        $this->authorize('restore', $tag);

        if ($tag->trashed()) {

            $tag->restore();

            return redirect()->route('tag.index')->withStatus(__('Tag successfully restored.'));
        }
    }
}
