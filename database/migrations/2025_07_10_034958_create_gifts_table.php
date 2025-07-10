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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();     // 'cows', 'ducks'
            $table->string('label');             // 'Cows'
            $table->string('title');             // 'A Gift of Cows'
            $table->string('image')->nullable(); // '/img/cow.png'
            $table->string('detail_image')->nullable();
            $table->longText('description')->nullable(); // HTML-formatted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifts');
    }
};
