<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Transactions & Booking.
 */
class Transaction extends Model
{
    use HasFactory;

    public const PROOF_DISK = 'local';
    public const PROOF_DIRECTORY = 'payment-proofs';

    protected $fillable = [
        'user_id', 'laptop_id', 'transaction_date', 'payment_method',
        'total_payment', 'proof_of_payment', 'status',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'payment_method' => PaymentMethod::class,
            'total_payment' => 'integer',
            'status' => TransactionStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function laptop(): BelongsTo
    {
        return $this->belongsTo(Laptop::class);
    }

    public function scopeOwnedBy(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->getKey());
    }

    public function scopeOfStatus(Builder $query, ?string $status): Builder
    {
        $status = TransactionStatus::tryFrom((string) $status);

        return $query->when($status, fn (Builder $q) => $q->where('status', $status));
    }

    /** Cari berdasarkan nama pembeli atau nama model laptop. */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when(filled($term), fn (Builder $q) => $q->where(
            fn (Builder $inner) => $inner
                ->whereHas('user', fn (Builder $user) => $user->where('name', 'like', "%{$term}%"))
                ->orWhereHas('laptop', fn (Builder $laptop) => $laptop->where('model_name', 'like', "%{$term}%"))
        ));
    }


    protected function formattedTotal(): Attribute
    {
        return Attribute::get(fn () => 'Rp '.number_format($this->total_payment, 0, ',', '.'));
    }

    public function isPending(): bool
    {
        return $this->status === TransactionStatus::Pending;
    }

    public function hasProof(): bool
    {
        return filled($this->proof_of_payment);
    }

    public function canUploadProof(): bool
    {
        return $this->isPending() && $this->payment_method->requiresProof();
    }

    public function canBeVerified(): bool
    {
        return $this->canUploadProof() && $this->hasProof();
    }

    public function canBeCompleted(): bool
    {
        return $this->isPending() && ! $this->payment_method->requiresProof();
    }

    public function canBeCancelled(): bool
    {
        return $this->isPending();
    }

    /** Jumlah transaksi per status, mis. ['Pending' => 3, 'Selesai' => 1]. */
    public static function countByStatus(): array
    {
        return static::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();
    }
}
