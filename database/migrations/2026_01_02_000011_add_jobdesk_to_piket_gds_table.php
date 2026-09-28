<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('piket_gds', function (Blueprint $table) {
            $table->string('jobdesk')->nullable()->after('shift'); // SIM, Tas, etc.
            $table->string('penempatan')->nullable()->after('jobdesk'); // Parkiran, Belakang
            $table->string('divisi')->nullable()->after('penempatan'); // DH, MPR, SEKBID X
        });
    }

    public function down(): void {
        Schema::table('piket_gds', function (Blueprint $table) {
            $table->dropColumn(['jobdesk', 'penempatan', 'divisi']);
        });
    }
};
