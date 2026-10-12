<?php

namespace App\Services;

use App\Enums\LaptopStatus;
use App\Enums\PaymentMethod;
use App\Enums\TransactionStatus;
use App\Exceptions\TransactionException;
use App\Models\Laptop;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionService
{
    public function book(User $buyer, Laptop $laptop, PaymentMethod $paymentMethod): Transaction
    {
        try {
            return DB::transaction(function () use ($buyer, $laptop, $paymentMethod) {
                $laptop = Laptop::query()->lockForUpdate()->findOrFail($laptop->getKey());

                if ($laptop->status !== LaptopStatus::Tersedia) {
                    throw TransactionException::laptopUnavailable();
                }

                $transaction = Transaction::create([
                    'user_id' => $buyer->getKey(),
                    'laptop_id' => $laptop->getKey(),
                    'transaction_date' => today(),
                    'payment_method' => $paymentMethod,
                    'total_payment' => $laptop->price, 
                    'status' => TransactionStatus::Pending,
                ]);

                $laptop->update(['status' => LaptopStatus::Terbooking]);

                return $transaction;
            });
        } catch (UniqueConstraintViolationException) {
            throw TransactionException::laptopUnavailable();
        }
    }

    public function uploadProof(Transaction $transaction, UploadedFile $proof): Transaction
    {
        return DB::transaction(function () use ($transaction, $proof) {
            $transaction = $this->lock($transaction);

            if (! $transaction->canUploadProof()) {
                throw TransactionException::proofNotAllowed();
            }

            $oldPath = $transaction->proof_of_payment;
            $newPath = $proof->store(Transaction::PROOF_DIRECTORY, Transaction::PROOF_DISK);

            $transaction->update(['proof_of_payment' => $newPath]);

            if ($oldPath) {
                Storage::disk(Transaction::PROOF_DISK)->delete($oldPath);
            }

            return $transaction;
        });
    }

    /** Admin memverifikasi bukti transfer: Pending -> Lunas, laptop Terjual. */
    public function verifyPayment(Transaction $transaction): Transaction
    {
        return DB::transaction(function () use ($transaction) {
            $transaction = $this->lock($transaction);

            if (! $transaction->canBeVerified()) {
                throw TransactionException::cannotVerify();
            }

            return $this->applyStatus($transaction, TransactionStatus::Lunas, LaptopStatus::Terjual);
        });
    }

    /** Admin done action transaksi COD: Pending -> Selesai, laptop Terjual. */
    public function completeCod(Transaction $transaction): Transaction
    {
        return DB::transaction(function () use ($transaction) {
            $transaction = $this->lock($transaction);

            if (! $transaction->canBeCompleted()) {
                throw TransactionException::cannotComplete();
            }

            return $this->applyStatus($transaction, TransactionStatus::Selesai, LaptopStatus::Terjual);
        });
    }

    /**
     * Admin membatalkan booking: Pending -> Dibatalkan, laptop kembali Tersedia.
     */
    public function cancel(Transaction $transaction): Transaction
    {
        return DB::transaction(function () use ($transaction) {
            $transaction = $this->lock($transaction);

            if (! $transaction->canBeCancelled()) {
                throw TransactionException::cannotCancel();
            }

            return $this->applyStatus($transaction, TransactionStatus::Dibatalkan, LaptopStatus::Tersedia);
        });
    }

    /**
     * Ambil data transaksi terbaru dan kunci barisnya untuk pembatasan klik ganda.
     */
    private function lock(Transaction $transaction): Transaction
    {
        return Transaction::query()->lockForUpdate()->findOrFail($transaction->getKey());
    }

    /** Ubah status transaksi dan status laptopnya sekaligus. */
    private function applyStatus(Transaction $transaction, TransactionStatus $transactionStatus, LaptopStatus $laptopStatus): Transaction
    {
        $transaction->update(['status' => $transactionStatus]);
        $transaction->laptop->update(['status' => $laptopStatus]);

        return $transaction;
    }
}
