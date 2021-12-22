<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    dd(User::with([
        'roles' => function ($query) {
            $query->select('id', 'name');
        },
        'roles.rolePermissions.permission' => function ($query) {
            $query->select('id', 'name');
        }, 
        'roles.rolePermissions.offices' => function ($query) {
            $query->select('id', 'name');
        }])
    ->find(auth()->id())->toArray());
});
