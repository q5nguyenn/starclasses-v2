<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChapterRequest extends FormRequest
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
			'content' => 'required',
			// 'video_link' => 'required',
		];
	}
	public function messages(): array
	{
		return [
			'course_id.required' => '*Course field cannot be left blank.',
			'content.required' => '*Content field cannot be left blank.',
			// 'video_link.required' => '*Video link field cannot be left blank.',
		];
	}
}
