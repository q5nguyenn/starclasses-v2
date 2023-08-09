<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
			'user_id' => 'required',
			'content' => 'required',
			'course_id' => 'required',
			'rate' => 'required',
			'status' => 'nullable'
		];
	}
	public function messages(): array
	{
		return [
			'user_id.required' => '*User field cannot be left blank.',
			'content.required' => '*Content field cannot be left blank.',
			'course_id.required' => '*Couser field cannot be left blank.',
			'rate.required' => '*Rate field cannot be left blank.',
		];
	}
}
