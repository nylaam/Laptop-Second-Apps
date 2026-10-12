<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\TransactionStatus;
use App\Models\Laptop;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Transaction> */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'laptop_id' => Laptop::factory(),
            'transaction_date' => today(),
            'payment_method' => PaymentMethod::Cod,
            'total_payment' => fake()->numberBetween(25, 150) * 100000,
            'proof_of_payment' => null,
            'status' => TransactionStatus::Pending,
        ];
    }

    public function transfer(): static
    {
        return $this->state(fn () => ['payment_method' => PaymentMethod::TransferManual]);
    }

    public function withProof(): static
    {
        return $this->state(fn () => ['proof_of_payment' => 'payment-proofs/fake.jpg']);
    }
}
