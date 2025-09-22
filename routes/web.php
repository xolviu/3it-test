<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZaznamyController;

Route::get("/", [ZaznamyController::class, "index"])->name("zaznamy.index");
Route::post("/download", [ZaznamyController::class, "download"])->name("zaznamy.download");
