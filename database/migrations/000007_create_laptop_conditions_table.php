<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laptop_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laptop_id')->unique()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('battery_health', 100);
            $table->string('screen_condition', 150);
            $table->string('keyboard_status', 150);
            $table->text('minus_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laptop_conditions');
    }
};
