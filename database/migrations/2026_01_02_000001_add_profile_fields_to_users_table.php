<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add extended profile fields to the users table.
     * Existing columns: id, name, email, username(8), password, role, remember_token, timestamps.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Jabatan/position title e.g. 'Ketua Umum', 'Sekretaris 1'
            $table->string('jabatan')->nullable()->after('role');

            // Sekbid number (0 = not sekbid-specific, 1-10 = sekbid number)
            $table->tinyInteger('bidang')->nullable()->default(0)->after('jabatan');

            // Academic year / angkatan e.g. '2024/2025'
            $table->string('angkatan')->nullable()->after('bidang');

            // Profile photo filename
            $table->string('foto')->nullable()->after('angkatan');

            // Soft-archive flag — 0 = alumni/inactive, 1 = active member
            $table->boolean('is_aktif')->default(1)->after('foto');

            // Organisational period e.g. '2024/2025'
            $table->string('periode')->nullable()->after('is_aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'bidang', 'angkatan', 'foto', 'is_aktif', 'periode']);
        });
    }
};
