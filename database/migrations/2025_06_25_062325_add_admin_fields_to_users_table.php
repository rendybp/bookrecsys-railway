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
            $table->string('member_id')->nullable()->after('name');
            $table->string('no_hp')->nullable()->after('email');
            $table->string('username')->unique()->after('no_hp');
            $table->enum('role', ['user', 'admin'])->default('user')->after('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['member_id', 'no_hp', 'username', 'role']);
        });
    }
};
