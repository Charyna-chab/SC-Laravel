<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SponsorsController;
use App\Http\Controllers\StaffsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\VolunteerProfileController;
use App\Models\VolunteerProfile;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/staffs', StaffsController::class);
Route::apiResource('/sponsors', SponsorsController::class);
Route::apiResource('/projects', ProjectController::class);
Route::apiResource('/teams', TeamController::class);
Route::apiResource('/volunteers', VolunteerProfileController::class);
