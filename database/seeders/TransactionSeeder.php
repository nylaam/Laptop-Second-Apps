<?php

namespace Database\Seeders;

use App\Enums\LaptopStatus;
use App\Enums\PaymentMethod;
use App\Enums\TransactionStatus;
use App\Models\Laptop;
use App\Models\Transaction;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Database\Seeder;


class TransactionSeeder extends Seeder
{
    public function run(TransactionService $transactions): void
    {
        $buyer = User::where('email', 'customer@laptopsecond.test')->first();

        if (! $buyer) {
            return;
        }

        // Pending, laptop Terbooking
        $this->book($transactions, $buyer, 'ThinkPad X270', PaymentMethod::TransferManual);
        $this->book($transactions, $buyer, 'VivoBook A412', PaymentMethod::Cod);

        // Dibatalkan, laptop kembali Tersedia
        $cancelled = $this->book($transactions, $buyer, 'ROG Strix G512', PaymentMethod::Cod);
        if ($cancelled) {
            $transactions->cancel($cancelled);
        }

        // Selesai: laptop demo yang memang sudah berstatus Terjual
        $sold = Laptop::where('model_name', 'Inspiron 3476')->first();
        if ($sold && $sold->status === LaptopStatus::Terjual && ! $sold->transactions()->exists()) {
            Transaction::create([
                'user_id' => $buyer->id,
                'laptop_id' => $sold->id,
                'transaction_date' => today()->subDays(7),
                'payment_method' => PaymentMethod::Cod,
                'total_payment' => $sold->price,
                'status' => TransactionStatus::Selesai,
            ]);
        }
    }

    private function book(TransactionService $transactions, User $buyer, string $model, PaymentMethod $method): ?Transaction
    {
        $laptop = Laptop::where('model_name', $model)->first();

        if (! $laptop || $laptop->transactions()->exists()) {
            return null;
        }

        return $transactions->book($buyer, $laptop, $method);
    }
}
