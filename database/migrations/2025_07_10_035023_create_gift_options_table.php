<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gift_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_id')->constrained('gifts')->onDelete('cascade');
            $table->string('label');     // "Share of a Cow"
            $table->decimal('price', 10, 2); // 200.00
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_options');
    }
};
