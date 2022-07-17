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

    public function index()
    {
        $permissions = $this->permissionRepository->all();

        return Inertia::render('App/Permission/Index', [
            'permissions' => $permissions
        ]);
    }

    public function store($request)
    {
        $this->permissionRepository->create($request);
        return  redirect()->route("permissions.index");
    }

    public function show($id)
    {
        $permission = $this->permissionRepository->find($id);

        return Inertia::render('App/Permission/Index', [
            'permission' => $permission
        ]);
    }

    public function update($request, $id)
    {
        $this->permissionRepository->update($request, $id);
        return  redirect()->route("permissions.index");
    }

    public function destroy($id)
    {
        $this->permissionRepository->delete($id);
        return  redirect()->route("permissions.index");
    }


    public function destroyAll($request)
    {
        $permissions = $request->all();

        foreach ($permissions as $permission) {
            $this->destroy($permission['id']);
        }

        return  redirect()->route("permissions.index");
    }
}