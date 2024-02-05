<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category'=>'required',
            'subcategory'=>'required',
            'brand'=>'required',
            'product_name'=>'required',
            'price'=>'required',
            'tags' => 'required',
            'long_desp'=>'required',
            'preview'=>'required|image',
            // 'gallery' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Example validation rules
            // 'gallery' => 'mimes:jpeg,png,jpg|max:20', // Example validation rules
            // 'gallery' => 'required |max: 1000|mimes:pdf,doc,docx,jpeg,jpg,png', // Example validation rules
            // 'gallery'=>'required|image',
        ];
    }
    public function messages(): array
    {
        return [
            'category.required'=>'Please Select Product Category',
            'subcategory.required'=>'Please Select Subcategory',
            'brand.required'=>'Please Write Product Brand',
            'product_name.required'=>'Please Write The Product Name',
            'price.required'=>'Please Insert Product Price',
            'tags.required' => 'Please Write Tags', // Error message for the 'tags' field
            'long_desp.required'=>'Please Fillup Long Description Field',
            'preview.required'=>'Please Upload Preview Image',
            'preview.image'=>'Please Upload an Image',
            // 'gallery[].required'=>'Please Upload Gallery Images',
            // 'gallery[].image'=>'Please Upload Images only',
            // 'gallery.*.required' => 'Each image is required.',
            // 'gallery.*.image' => 'Each uploaded file must be an image.',
        ];
    }
}
