<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
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
			'courses' => 'required',
		];
	}

	public function messages(): array
	{
		return [
			'user_id.required' => '*User field cannot be left blank.',
			'courses.required' => '*Course field cannot be left blank.'
		];
	}
}
