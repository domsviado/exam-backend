<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::post("/auth/login", [AuthController::class, "login"]);

Route::middleware(["auth:api"])->prefix("customers")->group(function () {
    Route::get("/", [CustomerController::class, "index"]);
    Route::post("/", [CustomerController::class, "store"]);
    Route::get("/{customer}", [CustomerController::class, "show"]);
    Route::put("/{customer}", [CustomerController::class, "update"]);
    Route::delete("/{customer}", [CustomerController::class, "destroy"]);
});