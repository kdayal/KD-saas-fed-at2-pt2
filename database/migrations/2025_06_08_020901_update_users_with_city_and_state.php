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
        Schema::table('users', function (Blueprint $table) {
            // Replace 100 with the actual size from Appendix D if different
            $table->string('city', 100)->nullable()->after('family_name'); // Example: add after 'family_name'
            $table->string('state', 100)->nullable()->after('city');    // Example: add after 'city'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['city', 'state']);
        });
    }
};
