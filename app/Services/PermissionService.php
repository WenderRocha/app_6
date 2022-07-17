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
        return $this->permissionRepository->find($id);
    }

    public function update($request, $id)
    {
        return $this->permissionRepository->update($request, $id);
    }

    public function destroy($id)
    {
        $this->permissionRepository->delete($id);
        return  redirect()->route("permissions.index");
    }


    public function destroyAll($request)
    {
        $permissions = $request->all();

        for ($i = 0; $i < count($permissions); $i++) {
            if ($permissions[$i]['id'] === 'null') {
                unset($permissions[$i]);
                $permissions = array_values($permissions);
            }
        }

        foreach ($permissions as $permission) {
            $this->destroy($permission['id']);
        }

        return  redirect()->route("permissions.index");
    }
}