<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComboRequest extends FormRequest
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
			'problem_solving' => 'required',
			'introduce' => 'required',
			'courses' => 'required',
			'price' => 'required',
			'expiration_date' => 'required',
		];
	}

	public function messages(): array
	{
		return [
			'name.required' => '*Name field cannot be left blank.',
			'problem_solving.required' => '*Problem solving field cannot be left blank.',
			'introduce.required' => '*Introduce field cannot be left blank.',
			'price.required' => '*Price field cannot be left blank.',
			'courses.required' => '*Course field cannot be left blank.',
			'exppiration_date.required' => '*Expiration date field cannot be left blank.'
		];
	}
}
