<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadProofRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('uploadProof', $this->route('transaction'));
    }

    public function rules(): array
    {
        return [
            'proof' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'proof.required' => 'Pilih file bukti transfer terlebih dahulu.',
            'proof.image' => 'Bukti transfer harus berupa file gambar.',
            'proof.mimes' => 'Bukti transfer harus berformat JPG, PNG, atau WEBP.',
            'proof.max' => 'Ukuran bukti transfer maksimal 2 MB.',
        ];
    }
}
