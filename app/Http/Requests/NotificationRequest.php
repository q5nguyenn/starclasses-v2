<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
			'users' => 'required',
			'title' => 'required',
			'description' => 'required',
		];
	}

	public function messages(): array
	{
		return [
			'users.required' => '*User field cannot be left blank.',
			'title.required' => '*Title field cannot be left blank.',
			'description.required' => '*Description field cannot be left blank.',
		];
	}
}
