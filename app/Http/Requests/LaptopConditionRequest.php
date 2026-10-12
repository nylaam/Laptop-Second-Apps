<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaptopConditionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            // Format baterai dibuat konsisten: angka 0-100 diikuti tanda %, mis. "85%"
            'battery_health' => ['required', 'string', 'regex:/^(100|[1-9]?[0-9])%$/'],
            'screen_condition' => ['required', 'string', 'max:150'],
            'keyboard_status' => ['required', 'string', 'max:150'],
            'minus_note' => ['nullable', 'string', 'max:1000'],
        ];

        // Laptop hanya dipilih saat membuat inspeksi baru.
        // Saat mengubah, laptopnya tidak boleh diganti.
        $isCreating = $this->route('condition') === null;

        if ($isCreating) {
            $rules['laptop_id'] = [
                'required',
                'exists:laptops,id',
                'unique:laptop_conditions,laptop_id',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'laptop_id.required' => 'Pilih laptop yang akan diinspeksi.',
            'laptop_id.exists' => 'Laptop yang dipilih tidak ditemukan.',
            'laptop_id.unique' => 'Laptop ini sudah punya lembar inspeksi.',
            'battery_health.required' => 'Kesehatan baterai wajib diisi.',
            'battery_health.regex' => 'Format baterai harus angka 0-100 diikuti %, mis. 85%.',
            'screen_condition.required' => 'Kondisi layar wajib diisi.',
            'screen_condition.max' => 'Kondisi layar maksimal 150 karakter.',
            'keyboard_status.required' => 'Status keyboard wajib diisi.',
            'keyboard_status.max' => 'Status keyboard maksimal 150 karakter.',
            'minus_note.max' => 'Catatan minus maksimal 1000 karakter.',
        ];
    }
}
