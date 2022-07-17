<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PermissionService;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionService $service
    ) {
    }

    public function index()
    {
        return $this->service->index();
    }

    public function store(Request $request)
    {
        //dd($request->all());
        return $this->service->store($request->all());
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }

    public function destroyAll(Request $request)
    {
        return $this->service->destroyAll($request);
    }
}