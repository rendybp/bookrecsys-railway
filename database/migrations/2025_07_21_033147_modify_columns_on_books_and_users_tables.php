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
        // Ubah ukuran kolom pada tabel books
        Schema::table('books', function (Blueprint $table) {
            $table->string('title', 100)->change();
            $table->string('author', 50)->nullable()->change();
            $table->string('publisher', 50)->nullable()->change();
            $table->string('ISBN', 50)->nullable()->change();
            $table->string('category', 30)->nullable()->change();
            // image sudah default 255 (tidak perlu diubah)
        });

        // Ubah ukuran kolom pada tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 50)->change();
            $table->string('member_id', 30)->nullable()->change();
            $table->string('email', 100)->change();
            $table->string('no_hp', 15)->nullable()->change();
            $table->string('username', 30)->change();
            $table->string('password', 100)->change();
            // role sudah enum, tidak perlu diubah
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke ukuran sebelumnya
        Schema::table('books', function (Blueprint $table) {
            $table->string('title', 255)->change();
            $table->string('author', 255)->nullable()->change();
            $table->string('publisher', 255)->nullable()->change();
            $table->string('ISBN', 255)->nullable()->change();
            $table->string('category', 255)->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 255)->change();
            $table->string('member_id', 255)->nullable()->change();
            $table->string('email', 255)->change();
            $table->string('no_hp', 255)->nullable()->change();
            $table->string('username', 255)->change();
            $table->string('password', 255)->change();
        });
    }
};
