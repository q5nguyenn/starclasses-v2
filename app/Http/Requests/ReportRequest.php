<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
			'type' => 'required',
			'description' => 'required',
			'image-report01' => [
				'nullable',
				'image',
				'max:500', // Max file size in kilobytes (KB)
			],
			'image-report02' => [
				'nullable',
				'image',
				'max:500', // Max file size in kilobytes (KB)
			],
			'image-report03' => [
				'nullable',
				'image',
				'max:500', // Max file size in kilobytes (KB)
			],
		];
	}

	public function messages(): array
	{
		return [
			'type.required' => '*Type field cannot be left blank.',
			'description.required' => '*Description field cannot be left blank.',
			'image-report01.image' => '*The file must be an image.',
			'image-report01.max' => '*The image size must be smaller than 500KB.',
			'image-report02.image' => '*The file must be an image.',
			'image-report02.max' => '*The image size must be smaller than 500KB.',
			'image-report03.image' => '*The file must be an image.',
			'image-report04.max' => '*The image size must be smaller than 500KB.',
		];
	}
}
