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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained();
            $table->foreignId('package_price_id')->constrained(); // Wajib tahu kamar tipe apa
            $table->string('customer_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->integer('jumlah_orang');
            $table->decimal('total_price', 15, 2); // Kunci total harganya di sini
            $table->enum('status', ['pending', 'dicicil', 'paid', 'cancel'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
