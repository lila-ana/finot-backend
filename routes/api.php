<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChurchGoodController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ElderController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Member routes
Route::get('/members', [MemberController::class, 'index']); // Get all members
Route::post('/members', [MemberController::class, 'store']); // Create a new member
Route::get('/members/{id}', [MemberController::class, 'show']); // Get a specific member
Route::put('/members/{id}', [MemberController::class, 'update']); // Update a specific member
Route::delete('/members/{id}', [MemberController::class, 'destroy']); // Delete a specific member
Route::post('/import-members', [MemberController::class, 'importMember']);



//Attendance routes
Route::get('/attendances', [AttendanceController::class, 'index']);     // Get all attendances
Route::get('/attendances/{id}', [AttendanceController::class, 'show']); // Get a single attendance
Route::post('/attendances', [AttendanceController::class, 'store']);    // Create an attendance
Route::put('/attendances/{id}', [AttendanceController::class, 'update']); // Update an attendance
Route::delete('/attendances/{id}', [AttendanceController::class, 'destroy']); // Delete an attendance


// Elder routes
// Route::apiResource('elders', ElderController::class);
Route::get('/elders', [ElderController::class, 'index']);     
Route::get('/elders/{id}', [ElderController::class, 'show']); 
Route::post('/elders', [ElderController::class, 'store']);   
Route::put('/elders/{id}', [ElderController::class, 'update']); 
Route::delete('/elders/{id}', [ElderController::class, 'destroy']);

// Class routes
// Route::apiResource('classes', ClassController::class);
Route::get('/classes', [ClassController::class, 'index']);     
Route::get('/classes/{id}', [ClassController::class, 'show']); 
Route::post('/classes', [ClassController::class, 'store']);   
Route::put('/classes/{id}', [ClassController::class, 'update']); 
Route::delete('/classes/{id}', [ClassController::class, 'destroy']);

// church goods routes
Route::apiResource('/church_goods', ChurchGoodController::class);

// categories routes
Route::apiResource('/categories', CategoryController::class);

// categories routes
// Route::apiResource('/events', EventController::class);
Route::get('/events', [EventController::class, 'index']);     
Route::get('/events/{id}', [EventController::class, 'show']); 
Route::post('/events', [EventController::class, 'store']);   
Route::put('/events/{id}', [EventController::class, 'update']); 
Route::delete('/events/{id}', [EventController::class, 'destroy']);   

