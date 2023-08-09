<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
			'name' => 'bail|required|min:5|max:100',
			'description' => 'required',
			'price' => 'required',
			'discount' => 'required',
			'department_id' => 'required',
			'learn' => 'required',
			'introduction' => 'required',
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
			'name.min' => '*Name must contain at least 5 and 100 characters.',
			'name.max' => 'Name must contain at least 5 and 100 characters.',
			'description.required' => '*Description field cannot be left blank.',
			// 'thumbnail.size' => '*Image size must be less than 500KB.',
			'price.required' => '*Price field cannot be left blank.',
			'discount.required' => '*Discount field cannot be left blank.',
			'department_id.required' => '*Department field cannot be left blank.',
			'learn.required' => '*Learn field cannot be left blank.',
			'introduction.required' => '*Introduction field cannot be left blank.',
			'thumbnail.image' => '*The file must be an image.',
			'thumbnail.max' => '*The image size must be smaller than 500KB.',
		];
	}
}
