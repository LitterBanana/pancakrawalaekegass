<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('departure_location')->nullable()->after('departure_date');
            $table->text('include_facility')->nullable()->after('description');
            $table->text('exclude_facility')->nullable()->after('include_facility');
            $table->text('itinerary')->nullable()->after('exclude_facility');
            $table->text('terms_conditions')->nullable()->after('itinerary');
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['departure_location', 'include_facility', 'exclude_facility', 'itinerary', 'terms_conditions']);
        });
    }
};