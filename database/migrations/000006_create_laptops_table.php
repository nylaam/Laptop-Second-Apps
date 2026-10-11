<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->string('model_name', 150);
            $table->string('processor', 150);
            $table->string('ram_storage', 100);
            $table->unsignedBigInteger('price');
            $table->string('image')->nullable();
            $table->enum('status', ['Tersedia', 'Terbooking', 'Terjual'])->default('Tersedia')->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
