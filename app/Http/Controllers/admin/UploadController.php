<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\Utilities;

class UploadController extends Controller
{
	use Utilities;
	public function upload(Request $request)
	{
		return response()->json(['name' => 'có name']);
		if ($request->hasFile('image')) {
			$image = $request->file('image');

			// Lưu trữ ảnh trong app gốc (cổng 8080)
			$path = $image->store('images', 'public');

			// Xử lý các thao tác khác sau khi lưu trữ thành công
			// ...

			return response()->json(['message' => 'Upload successful'], 200);
		}

		return response()->json(['message' => 'No file selected'], 400);
	}
}
