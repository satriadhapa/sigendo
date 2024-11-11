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
            $table->string('nomor_induk_pegawai')->unique()->nullable()->after('password');
            $table->string('jabatan_akademik')->nullable()->after('nomor_induk_pegawai');
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studi')->onDelete('set null')->after('jabatan_akademik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nomor_induk_pegawai', 'jabatan_akademik', 'program_studi_id']);
        });
    }
};
