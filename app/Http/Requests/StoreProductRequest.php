<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'name'        => 'required|max:20',
			'description' => 'required',
			'price'       => 'required|numeric|min:2',
			'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
			'category_id' => 'required|integer|exists:categories,id',
			'stock'       => 'required|integer|min:0',
		];
	}
	
	public function messages()
	{
		return [
			'name.required'     => 'Product name is required.',
			'name.max'          => 'Product name must not exceed 20 characters.',

			'description.required'     => 'Product description is required.',

			'price.required'    => 'Product price is required.',
			'price.numeric'     => 'Product price must be a valid number.',
			'price.min'         => 'Product price min 2 digit.',

			'image.required'    => 'Product image is required.',
			'image.image'       => 'Uploaded file must be an image.',
			'image.mimes'       => 'Allowed image types: jpeg, png, jpg.',
			'image.max'         => 'Image size must not exceed 2MB.',

			'stock.required'    => 'Stock quantity is required.',
			'stock.integer'     => 'Stock must be an integer.',

			'category_id.required' => 'Category is required.',
			'category_id.exists'   => 'Selected category does not exist.'
		];
	}
}
