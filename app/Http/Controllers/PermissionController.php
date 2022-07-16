<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PermissionService;
use PhpParser\Node\Stmt\Foreach_;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionService $service
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->service->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->service->destroy($id);
    }

    public function destroyAll(Request $request)
    {
        $permissions = $request->all();

        for ($i = 0; $i < count($permissions); $i++) {
            if ($permissions[$i]['id'] === 'null') {
                unset($permissions[$i]);
                $permissions = array_values($permissions);
            }
        }

        foreach ($permissions as $permissions) {
            $this->destroy($permissions['id']);
        }


        //dd($permissions);
        return  redirect()->route("permissions.index");
    }
}