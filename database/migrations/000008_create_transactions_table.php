<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('laptop_id')->constrained()->restrictOnDelete();
            $table->date('transaction_date');
            $table->enum('payment_method', ['COD', 'Transfer Manual']);
            $table->unsignedBigInteger('total_payment'); 
            $table->string('proof_of_payment')->nullable();
            $table->enum('status', ['Pending', 'Lunas', 'Selesai', 'Dibatalkan'])->default('Pending')->index();

            $table->unsignedBigInteger('active_laptop_id')
                ->nullable()
                ->storedAs("CASE WHEN status <> 'Dibatalkan' THEN laptop_id ELSE NULL END")
                ->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
