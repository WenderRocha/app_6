<?php

namespace App\Services;

use App\Repositories\Contracts\PermissionRepositoryInterface;

class PermissionService
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Service Layer - Get a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        return $this->permissionRepository->all();
    }

    /**
     * Service Layer - Store a newly created resource in storage.
     *
     * @return \Illuminate\Support\Collection
     */
    public function store($request)
    {
        return $this->permissionRepository->create($request);
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
