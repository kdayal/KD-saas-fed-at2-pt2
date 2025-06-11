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
            $table->string('given_name', 100)->nullable()->after('name'); // Example: add after 'name' column
            $table->string('family_name', 100)->nullable()->after('given_name'); // Example: add after 'given_name'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['given_name', 'family_name']);
        });
    }
};
