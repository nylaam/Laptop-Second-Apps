<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Hardware Inspection.
 * Satu laptop punya maksimal satu lembar inspeksi (one-to-one).
 */
class LaptopCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'laptop_id', 'battery_health', 'screen_condition',
        'keyboard_status', 'minus_note',
    ];

    public function laptop(): BelongsTo
    {
        return $this->belongsTo(Laptop::class);
    }

    /** Cari inspeksi berdasarkan nama model / prosesor laptopnya. */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when(filled($term), fn (Builder $q) => $q->whereHas(
            'laptop',
            fn (Builder $laptop) => $laptop->search($term)
        ));
    }
}
