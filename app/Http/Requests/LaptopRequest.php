<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaptopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'model_name' => trim((string) $this->input('model_name')),
            'processor' => trim((string) $this->input('processor')),
            'ram_storage' => trim((string) $this->input('ram_storage')),
        ]);
    }

    public function rules(): array
    {
        return [
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'model_name' => ['required', 'string', 'max:150'],
            'processor' => ['required', 'string', 'max:150'],
            'ram_storage' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:1', 'max:999999999999'],
            'description' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'brand_id' => 'merek',
            'model_name' => 'nama model',
            'processor' => 'prosesor',
            'ram_storage' => 'RAM/storage',
            'price' => 'harga',
            'description' => 'deskripsi',
            'image' => 'foto',
        ];
    }

    public function messages(): array
    {
        return [
            'brand_id.required' => 'Merek wajib dipilih.',
            'brand_id.exists' => 'Merek yang dipilih tidak valid.',
            'price.integer' => 'Harga harus berupa angka bulat (rupiah, tanpa titik/koma).',
            'price.min' => 'Harga harus lebih dari 0.',
            'image.image' => 'Foto harus berupa file gambar.',
            'image.mimes' => 'Foto harus berformat JPG, PNG, atau WEBP.',
            'image.max' => 'Ukuran foto maksimal 2 MB.',
        ];
    }
}
