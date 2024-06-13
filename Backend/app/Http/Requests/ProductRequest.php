<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
    // public function rules(): array
    // {
    //     return [
    //         'name'       => 'required|max:255|unique:products',
    //         'description' => 'required',
    //         'price'       => 'required',
    //         'image'       => 'string|mimes:jpeg,png,jpg,gif|max:2048',
    //         'attributes' => 'sometimes|array',
    //         'attributes.*.name' => 'required_with:attributes|string',
    //         'attributes.*.value' => 'required_with:attributes|string',
    //         'category_id' => ['required',
    //             Rule::exists('categories', 'id'),
    //         ],
    //     ];
    // }

    public function rules()
{
    return [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        // 'category_id' => 'required|exists:categories,id',
        'categories' => 'required|array',

        'attributes' => 'nullable|array',
        'attributes.*.name' => 'required_with:attributes|max:255',
        'attributes.*.value' => 'required_with:attributes|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];
}


    // public function messages(): array
    // {
    //     return [
    //         'name.required'        => 'Product Name is required and must be unique',
    //         'description.required' => 'Product description is required',
    //         'price.required'       => 'Product price is required',
    //         // 'image.required'                => 'Product image is required',
    //         'category_id.required' => 'Category ID is required and must exist',
    //     ];
    // }
}
