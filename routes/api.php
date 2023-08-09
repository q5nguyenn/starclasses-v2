<?php

use App\Http\Controllers\Api\SearchController;
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

// Route::get('search', [SearchController::class, 'index']);

// Route Upload Ảnh
Route::get('/upload', function (Request $request) {
	dd('upload');
	if ($request->hasFile('image')) {
		$image = $request->file('image');

		// Lưu trữ ảnh trên server đích
		$path = $image->store('public/thumbnails');

		return response()->json(['message' => 'Upload successful', 'path' => $path]);
	}

	return response()->json(['message' => 'No image file found'], 400);
});
