<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'course_id' => 'required',
			'thumbnail' => [
				'nullable',
				'image',
				'max:500', // Max file size in kilobytes (KB)
			],
		];
	}

	public function messages(): array
	{
		return [
			'course_id.required' => '*Course field cannot be left blank.',
			'thumbnail.image' => '*The file must be an image.',
			'thumbnail.max' => '*The image size must be smaller than 500KB.',
		];
	}
}
