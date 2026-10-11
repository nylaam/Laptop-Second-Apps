<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['brand_name', 'slug'];

    /**
     * Slug always extend from nama merek, always sinkron with 
     * (controller, seeder, tinker)
     */
    protected static function booted(): void
    {
        static::saving(function (Brand $brand) {
            $brand->slug = Str::slug($brand->brand_name);
        });
    }

    public function laptops(): HasMany
    {
        return $this->hasMany(Laptop::class);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when(
            filled($term),
            fn (Builder $q) => $q->where('brand_name', 'like', "%{$term}%")
        );
    }
}
