<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
	public function index(Request $request)
	{
		$client = new Client();

		try {
			$response = $client->request('GET', 'https://provinces.open-api.vn/api/?depth=3');
			$data = json_decode($response->getBody(), true);

			return $data;

			return response()->json($data);
		} catch (\Exception $e) {
			// Xử lý lỗi nếu có

			return response()->json(['error' => $e->getMessage()], 500);
		}
	}
}
