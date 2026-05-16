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
            $table->string('login_token')->nullable()->unique();
            $table->timestamp('login_token_expires_at')->nullable();
            $table->boolean('is_password_set')->default(false);
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['login_token', 'login_token_expires_at', 'is_password_set']);
            $table->string('password')->nullable(false)->change();
        });
    }
};
