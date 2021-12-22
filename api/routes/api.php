<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BiometricsController;
use App\Http\Controllers\Api\OfficeController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);

Route::apiResource('auth', AuthController::class);

Route::apiResource('biometrics', BiometricsController::class);

Route::apiResource('roles', RoleController::class);

Route::apiResource('user_roles', UserRoleController::class);

Route::apiResource('permissions', PermissionController::class);

Route::apiResource('offices', OfficeController::class);