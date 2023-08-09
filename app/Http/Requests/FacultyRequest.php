<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyRequest extends FormRequest
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
			'name' => 'bail|required',
			'icon' => 'required',
		];
	}

	public function messages(): array
	{
		return [
			'name.required' => '*Name field cannot be left blank.',
			'icon.required' => '*Icon field cannot be left blank.',
		];
	}
}
