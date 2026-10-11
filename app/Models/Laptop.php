<?php

namespace App\Models;

use App\Enums\LaptopStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

/**
 * CATATAN TIM: model ini milik Anggota 1 (Laptop & Inventory).
 * Versi di bawah adalah versi minimal agar modul Katalog bisa berjalan.
 * Saat merge, pertahankan relasi dan scope katalog (search, ofBrand, available).
 */
class Laptop extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id', 'model_name', 'processor', 'ram_storage',
        'price', 'image', 'status', 'description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'status' => LaptopStatus::class,
        ];
    }

    // ---- Relasi ----

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function condition(): HasOne
    {
        return $this->hasOne(LaptopCondition::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when(filled($term), fn (Builder $q) => $q->where(
            fn (Builder $inner) => $inner
                ->where('model_name', 'like', "%{$term}%")
                ->orWhere('processor', 'like', "%{$term}%")
        ));
    }

    public function scopeOfBrand(Builder $query, ?int $brandId): Builder
    {
        return $query->when($brandId, fn (Builder $q) => $q->where('brand_id', $brandId));
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', LaptopStatus::Tersedia);
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::get(fn () => 'Rp '.number_format($this->price, 0, ',', '.'));
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image ? Storage::url($this->image) : null);
    }
}
