<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
			'password' => 'required',
			'password_new' => 'bail|required|min:6|confirmed',
		];
	}
	public function messages(): array
	{
		return [
			'password.required' => '*Password field cannot be left blank.',
			'password_new.min' => '*Password must contain at least 5 characters.',
			'password_new.required' => '*Password field cannot be left blank.',
			'password_new.confirmed' => '*Password do not match.',
		];
	}
}
