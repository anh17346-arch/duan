<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'name_en'     => ['nullable', 'string', 'max:255'],
            'brand'       => ['nullable', 'string', 'max:255'],
            'gender'      => ['required', Rule::in(['male', 'female', 'unisex'])],
            'volume_ml'   => ['required', 'integer', 'min:1', 'max:1000'],
            'price'       => ['required', 'integer', 'min:0'],
            'sale_price'  => ['nullable', 'integer', 'min:0', 'lte:price'],
            'short_desc'  => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'stock'       => ['required', 'integer', 'min:0'],
            'sku'         => ['required', 'string', 'max:100'],
            'origin'      => ['nullable', 'string', 'max:100'],
            'concentration' => ['required', Rule::in(['EDC', 'EDT', 'EDP', 'Parfum', 'Extrait'])],
            'is_featured' => 'boolean',
            'is_on_sale' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_new' => 'boolean',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after:sale_start_date',
            'views_count' => 'nullable|integer|min:0',
            'sold_count' => 'nullable|integer|min:0',
            'status'      => ['required', Rule::in([0, 1])],
            'main_image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];

        // Nếu là update, không bắt buộc main_image
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['main_image'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists'   => 'Danh mục không tồn tại.',
            'name.required'        => 'Tên sản phẩm không được để trống.',
            'name.max'             => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'gender.required'      => 'Vui lòng chọn giới tính.',
            'gender.in'            => 'Giá trị giới tính không hợp lệ.',
            'volume_ml.required'   => 'Dung tích không được để trống.',
            'volume_ml.min'        => 'Dung tích phải lớn hơn 0.',
            'volume_ml.max'        => 'Dung tích không được vượt quá 1000ml.',
            'price.required'       => 'Giá không được để trống.',
            'price.min'            => 'Giá phải lớn hơn hoặc bằng 0.',
            'sale_price.lte'       => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc.',
            'stock.required'       => 'Số lượng tồn kho không được để trống.',
            'stock.min'            => 'Số lượng tồn kho phải lớn hơn hoặc bằng 0.',
            'status.required'      => 'Trạng thái không được để trống.',
            'status.in'            => 'Trạng thái không hợp lệ.',
            'main_image.image'     => 'File phải là hình ảnh.',
            'main_image.mimes'     => 'Hình ảnh phải có định dạng: jpg, jpeg, png, webp.',
            'main_image.max'       => 'Kích thước hình ảnh không được vượt quá 4MB.',
            'gallery_images.*.image' => 'File gallery phải là hình ảnh.',
            'gallery_images.*.mimes' => 'Ảnh gallery phải có định dạng: jpg, jpeg, png, webp.',
            'gallery_images.*.max'   => 'Kích thước ảnh gallery không được vượt quá 4MB.',
        ];
    }
}
