<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodeRequest extends FormRequest
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
			'name' => 'required',
			'course_id' => 'required',
			'time' => 'required|numeric|min:0',
		];
	}
	public function messages(): array
	{
		return [
			'name.required' => '*Code name field cannot be left blank.',
			'course_id.required' => '*Course field cannot be left blank.',
			'time.required' => '*Time field cannot be left blank.',
			'time.numeric' => '*Time field must be a number.',
			'time.min' => '*The small value is 0.',
		];
	}
}
