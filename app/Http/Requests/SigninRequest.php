<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SigninRequest extends FormRequest
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
			'email' => 'bail|required|email|exists:users,email',
			'password' => 'required',
		];
	}

	public function messages(): array
	{
		return [
			'email.required' => '*Email field cannot be left blank.',
			'email.email' => '*Email invalidate.',
			'email.exists' => '*Email does not exist.',
			'password.required' => '*Password field cannot be left blank.',
		];
	}
}
