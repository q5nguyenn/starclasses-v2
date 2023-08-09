<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SignupRequest extends FormRequest
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
			'email' => 'bail|required|email|unique:users,email',
			'phone_number' => [
				'bail',
				Rule::unique('users', 'phone_number')->where(function ($query) {
					return $query->whereNotNull('phone_number');
				}),
				'nullable',
				'regex:/(0)[0-9]{9}/'
			]
		];
	}

	public function messages(): array
	{
		return [
			'name.required' => '*Name field cannot be left blank.',
			'email.required' => '*Email field cannot be left blank.',
			'email.email' => '*Email invalidate.',
			'email.unique' => '*Email already exists.',
			'phone_number.unique' => '*Phone number already exists.',
			'phone_number.regex' => '*Phone number invalidate.',
			'password.required' => '*Password field cannot be left blank.',
			'checkbox.accepted' => '*Please agree to the website terms and conditions.',
		];
	}
}
