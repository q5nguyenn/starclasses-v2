<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
		$user = Auth::user();
		return [
			'name' => 'bail|required|min:5|max:100',
			'email' => [
				'required',
				'email',
				Rule::unique('users', 'email')->ignore($user),
			],
			'phone_number' => [
				'nullable',
				'regex:/^(0)?[0-9]{9}$/',
				Rule::unique('users', 'phone_number')->ignore($user),
			],
			'thumbnail' => [
				'nullable',
				'image',
				'max:500', // Max file size in kilobytes (KB)
			],
		];
	}
	public function messages(): array
	{
		return [
			'name.required' => '*Name field cannot be left blank.',
			'name.min' => '*Name must contain at least 5 characters.',
			'name.max' => '*Email must contain at most 100 characters.',
			'email.required' => '*Email field cannot be left blank.',
			'email.email' => '*Email is invalid.',
			'email.unique' => '*Email already exists.',
			'phone_number.regex' => '*Phone number is invalid.',
			'phone_number.unique' => '*Phone number already exists.',
			'thumbnail.image' => '*The file must be an image.',
			'thumbnail.max' => '*The image size must be smaller than 500KB.',
		];
	}
}
