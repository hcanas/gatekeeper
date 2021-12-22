<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOffice;
use App\Http\Requests\UpdateOffice;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offices = Office::with('parentOffice')->get();

        return response()->json($offices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOffice  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOffice $request)
    {
        try {
            $office = Office::create($request->validated());

            return response()->json($office);
        } catch (\Exception $e) {
            logger($e);
            return response()->json('Unable to create office. Please try again later.', 500);
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
     * @param  UpdateOffice $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOffice $request, $id)
    {
        try {
            $office = Office::find($id);

            if ($office === null) {
                return response()->json('Office not found.', 404);
            }

            $office->fill($request->validated())->save();
            $office->parent_office = $office->parentOffice()->first();

            return response()->json($office);
        } catch (\Exception $e) {
            logger($e);
            return response()->json('Unable to update office. Please try again later.', 500);
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
