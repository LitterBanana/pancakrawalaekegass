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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // --- Tambahan berdasarkan skema dokumen ---
            $table->string('invoice_number')->unique(); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            // ------------------------------------------

            // Relasi ke tabel bookings. Jika booking dihapus, riwayat cicilan ikut terhapus.
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade'); 
            
            // Menggunakan bigInteger karena mata uang Rupiah (IDR) nominalnya puluhan juta
            $table->bigInteger('amount'); 
            
            $table->date('payment_date');
            
            // --- Penyesuaian ke Enum & Tambahan Nama Bank ---
            $table->enum('payment_method', ['tunai', 'transfer']);
            $table->string('bank_name')->nullable(); // Pilihan bank jika transfer
            // ------------------------------------------------
            
            $table->string('proof_of_payment')->nullable(); // Boleh kosong jika bayar cash
            
            // --- Tambahan status pembayaran (Verifikasi Admin) ---
            $table->enum('status', ['belum_lunas', 'sudah_lunas', 'ditolak'])->default('belum_lunas');
            // -----------------------------------------------------

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};