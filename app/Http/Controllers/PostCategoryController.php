<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostCategory $postCategories, Request $request)
    {
        $this->authorize('view', PostCategory::class);

        return view('post-categories.index', ['postCategories' => $postCategories->search($request->q)->withTrashed()->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', PostCategory::class);

        return view('post-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', PostCategory::class);

        PostCategory::create($request->merge([
          'slug' => $request->name
          ])->all());

        return redirect()->route('post-category.index')->withStatus(__('Post Category successfully created.'));
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
    public function edit(PostCategory $postCategory)
    {
        $this->authorize('update', PostCategory::class);

        return view('post-categories.edit', compact('postCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostCategory $postCategory)
    {
          $this->authorize('update', PostCategory::class);

          $postCategory->update($request->merge([
            'slug' => $request->name
            ])->all());

          return redirect()->route('post-category.index')->withStatus(__('Post Category successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostCategory $postCategory)
    {
        if ($postCategory->trashed()) {
            $this->authorize('forceDelete', PostCategory::class);
            
            if ($postCategory->children()->count() > 0) {
                $postCategory->children()->update(['parent_id' => null]);
            }

            $postCategory->forceDelete();

            return redirect()->route('post-category.index')->withStatus(__('Post Category successfully force deleted.'));
        }

        $this->authorize('delete', PostCategory::class);
        $postCategory->delete();

        return redirect()->route('post-category.index')->withStatus(__('Post Category successfully deleted.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, PostCategory $postCategory)
    {
        $this->authorize('restore', $postCategory);

        if ($postCategory->trashed()) {

            $postCategory->restore();

            return redirect()->route('post-category.index')->withStatus(__('Post Category successfully restored.'));
        }
    }
}
