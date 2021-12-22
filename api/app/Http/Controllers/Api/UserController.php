<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $users = User::with('roles')
            ->get();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUser $request)
    {
        try {
            $user = User::create($request->validated());

            return response()->json($user);
        } catch (\Exception $e) {
            logger($e);
            return response()->json('Unable to create user. Please try again later.', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        if ($user === null) {
            return response()->json('User not found.', 404);
        } else {
            return response()->json($user);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUser $request
     * @param  User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUser $request, User $user)
    {
        try {
            $data = $request->validated();

            if ($data['password']) {
                $data['password'] = Hash::make($data['password']);

                DB::table('sessions')
                    ->where('user_id', $user->id)
                    ->delete();
            } else {
                $data['password'] = $user->password;
            }

            $user->fill($data);
            $user->save();
            $user->roles = $user->roles()->get();

            return response()->json($user);
        } catch (\Exception $e) {
            logger($e);
            return response()->json('Unable to update user. Please try again later.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
    }
}
