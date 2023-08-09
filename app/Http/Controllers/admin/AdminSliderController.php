<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Course;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Traits\Utilities;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AdminSliderController extends Controller
{
	use Utilities;
	public function index(Request $request)
	{
		$list = Slider::all();
		return view('admin.slider.index', [
			'list' => $list
		]);
	}
	public function create(Request $request)
	{
		$list = Course::all();
		return view('admin.slider.create', [
			'list' => $list,
		]);
	}
	public function store(SliderRequest $request)
	{
		$url = $this->storeUpload($request, 'thumbnail', 'sliders');
		if (empty($url)) {
			$url = "/images/slider-default.jpg";
		}
		$slider = Slider::create([
			'course_id' => $request->course_id,
			'thumbnail' => $url
		]);
		return redirect()->route('admin.slider.index');
	}

	public function edit(Request $request)
	{
		$list = Course::all();
		$slider = Slider::find($request->id);
		return view('admin.slider.edit', [
			'slider' => $slider,
			'list' => $list
		]);
	}

	public function update(SliderRequest $request)
	{
		$slider = Slider::find($request->id);
		$url = $this->storeUpload($request, 'thumbnail', 'sliders');
		if (empty($url)) {
			$url = $slider->thumbnail;
		} else {
			$this->deleteFile($slider->thumbnail);
		}
		$slider = Slider::where('id', $request->id)->update([
			'course_id' => $request->course_id,
			'thumbnail' => $url
		]);
		return redirect()->route('admin.slider.index');
	}

	public function delete(Request $request)
	{
		try {
			DB::beginTransaction();
			$slider = Slider::find($request->id);
			if ($slider) {
				$thumbnail = $slider->thumbnail;
				$slider->delete();
				$this->deleteFile($thumbnail);
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'Slider not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete slider because there are related somethings!'
			]);
		}
	}
}
