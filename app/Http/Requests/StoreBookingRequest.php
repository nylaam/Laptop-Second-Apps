<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Transaction::class);
    }

    public function rules(): array
    {
        return [
            'payment_method' => ['required', Rule::enum(PaymentMethod::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => 'Pilih metode pembayaran.',
            'payment_method.enum' => 'Metode pembayaran harus COD atau Transfer Manual.',
        ];
    }

    public function paymentMethod(): PaymentMethod
    {
        return $this->enum('payment_method', PaymentMethod::class);
    }
}
