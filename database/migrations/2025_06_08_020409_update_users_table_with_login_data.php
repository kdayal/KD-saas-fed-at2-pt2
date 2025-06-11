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
            $table->dateTime('login_at')->nullable(); // Adds a nullable datetime column for login_at
            $table->dateTime('logout_at')->nullable(); // Adds a nullable datetime column for logout_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['login_at', 'logout_at']); // Drops the columns if migration is rolled back
        });
        // The original instruction also showed Schema::dropColumns('users', ['login_at', 'logout_at']); which is also correct.
    }
};
