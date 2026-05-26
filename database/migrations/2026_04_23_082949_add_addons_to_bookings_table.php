<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom add-ons ke tabel bookings.
     * Disimpan sebagai JSON agar fleksibel tanpa perlu tabel terpisah.
     * Struktur JSON: { "addon_key": qty, ... }
     * Contoh: { "paspor": 2, "bisnis_class": 1, "upgrade_kamar": 0, "vaksin": 2 }
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Menyimpan pilihan add-on user dalam format JSON
            $table->json('addons')->nullable()->after('total_price');
            // Kurs USD saat booking dikunci (agar tidak berubah walaupun kurs bergerak)
            $table->decimal('usd_rate', 10, 2)->nullable()->after('addons')->comment('Kurs USD/IDR saat booking dibuat');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['addons', 'usd_rate']);
        });
    }
};
