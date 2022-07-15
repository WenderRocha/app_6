<?php

namespace App\Services;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use Inertia\Inertia;

class PermissionService
{
    public function __construct(
        protected PermissionRepositoryInterface $permissionRepository
    ) {
    }

    /**
     * Service Layer - Get a listing of the resource.
     */
    public function index()
    {
        $permissions = $this->permissionRepository->all();

        return Inertia::render('App/Permission/Index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Service Layer - Store a newly created resource in storage.
     *
     * @return \Illuminate\Support\Collection
     */
    public function store($request)
    {
        sleep(3);
        $this->permissionRepository->create($request);
        return  redirect()->route("permissions.index");
    }

    /**
     * Service Layer - Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Support\Collection
     */
    public function show($id)
    {
        return $this->permissionRepository->find($id);
    }

    /**
     * Service Layer - Update the specified resource in storage.
     *
     * @param  array  $request
     * @param  int  $id
     * @return \Illuminate\Support\Collection
     */
    public function update($request, $id)
    {
        return $this->permissionRepository->update($request, $id);
    }

    /**
     * Service Layer - Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Support\Collection
     */
    public function destroy($id)
    {
        return $this->permissionRepository->delete($id);
    }
}