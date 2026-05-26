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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->date('departure_date');
            $table->date('return_date');
            $table->integer('duration'); // dalam hitungan hari
            $table->integer('quota');
            $table->foreignId('hotel_makkah_id')->nullable()->constrained('hotels')->nullOnDelete();
            $table->foreignId('hotel_madinah_id')->nullable()->constrained('hotels')->nullOnDelete();
            $table->string('airline')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
