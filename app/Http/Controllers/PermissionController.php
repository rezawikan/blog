<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Permission $permissions, Request $request)
    {
        $this->authorize('view', Permission::class);

        return view('permissions.index', ['permissions' => $permissions->search($request->q)->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Permission::class);

        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);
        $permission = Permission::create($request->only('name'));

        if ($request->has('roles')) {
            $permission->roles()->attach($request->roles);
        }

        return redirect()->route('permission.index')->withStatus(__('Permission successfully created.'));
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
    public function edit(Permission $permission)
    {
        $this->authorize('update', Permission::class);

        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->authorize('update', Permission::class);

        $permission->update($request->except('roles'));

        $permission->roles()->sync($request->roles);

        return redirect()->route('permission.index')->withStatus(__('Permission successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {

        $this->authorize('delete', Permission::class);

        $permission->roles()->detach();
        $permission->delete();

        return redirect()->route('permission.index')->withStatus(__('Permission successfully deleted.'));
    }
}
