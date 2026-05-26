<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('destinations', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Contoh: San Miguel
        $table->string('location'); // Contoh: Italy
        $table->string('image'); // Untuk menyimpan nama file gambar
        $table->text('description')->nullable();
        $table->integer('rating')->default(5); // Bintang 1-5
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
