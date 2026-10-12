<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

/**
 * Aksi nya admin (verifikasi, selesai, batal) 
 */
class TransactionPolicy
{
    /** Hanya pembeli yang membuat booking (admin mengelola, not membeli). */
    public function create(User $user): bool
    {
        return ! $user->isAdmin();
    }

    /** Pembeli hanya boleh melihat transaksinya sendiri */
    public function view(User $user, Transaction $transaction): bool
    {
        return $user->isAdmin() || $transaction->user_id === $user->getKey();
    }

    /** Hanya pemilik transaksi yang bisa mengunggah bukti transfer. */
    public function uploadProof(User $user, Transaction $transaction): bool
    {
        return $transaction->user_id === $user->getKey();
    }
}
