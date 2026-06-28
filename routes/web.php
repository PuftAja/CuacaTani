<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return view("welcome");
});

// Dashboard → pakai controller untuk inject data cuaca + rekomendasi
Route::get("/dashboard", [DashboardController::class, "index"])
    ->middleware(["auth", "verified"])
    ->name("dashboard");

Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update",
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy",
    );

    // Route CRUD lahan — hanya bisa diakses petani yang sudah login
    Route::resource("lahan", LahanController::class);
});

require __DIR__ . "/auth.php";
