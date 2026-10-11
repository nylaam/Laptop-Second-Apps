<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'brand_name' => trim((string) $this->input('brand_name')),
            'slug' => Str::slug((string) $this->input('brand_name')),
        ]);
    }

    public function rules(): array
    {
        $brand = $this->route('brand'); 

        return [
            'brand_name' => [
                'required', 'string', 'max:100',
                Rule::unique('brands', 'brand_name')->ignore($brand),
            ],
            'slug' => [
                'required', 'string', 'max:120',
                Rule::unique('brands', 'slug')->ignore($brand),
            ],
        ];
    }

    public function attributes(): array
    {
        return ['brand_name' => 'nama merek', 'slug' => 'nama merek'];
    }

    public function messages(): array
    {
        return [
            'brand_name.required' => 'Nama merek wajib diisi.',
            'brand_name.unique' => 'Merek ini sudah terdaftar.',
            'slug.unique' => 'Merek dengan penulisan serupa sudah terdaftar.',
        ];
    }
}
