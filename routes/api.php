<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


/**
 * PUBLIC ROUTE
 */
Route::post("/login", [AuthController::class, "login"]);
Route::post("/login/google", [AuthController::class, "loginGoogle"]);

Route::middleware('auth:api')->group(function () {
    Route::get("/profile", [AuthController::class, "profile"]);
    Route::post("/logout", [AuthController::class, "logout"]);

    Route::apiResource("user", UserController::class)->except(["destroy"]);

    Route::post("role/sync/permission", [RoleController::class, "syncPermissions"]);
    Route::apiResource("role", RoleController::class);

    Route::apiResource("permission", PermissionController::class);
});
