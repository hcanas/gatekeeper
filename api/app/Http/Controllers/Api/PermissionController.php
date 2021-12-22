<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePermission;
use App\Http\Requests\UpdatePermission;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $permissions = Permission::get();

        return response()->json($permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePermission  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePermission $request)
    {
        try {
            $permission = Permission::create($request->validated());

            return response()->json($permission);
        } catch (\Exception $e) {
            logger($e);
            return response()->json('Unable to create permission. Please try again later.', 500);
        }
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
     * Update the specified resource in storage.
     *
     * @param  UpdatePermission  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermission $request, $id)
    {
        try {
            $permission = Permission::find($id);

            if ($permission === null) {
                return response()->json('Permission not found.', 404);
            }

            $permission->fill($request->validated())->save();

            return response()->json($permission);
        } catch (\Exception $e) {
            logger($e);
            return response()->json('Unable to update permission. Please try again later.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
