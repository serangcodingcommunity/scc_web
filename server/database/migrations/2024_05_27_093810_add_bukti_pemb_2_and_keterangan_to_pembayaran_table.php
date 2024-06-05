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
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->string('bukti_pemb_2')->after('bukti_pemb');
            $table->dropColumn('keterangan');
            $table->string('keterangan_admin')->after('bukti_pemb_2');
            $table->string('keterangan_user')->after('keterangan_admin');
            $table->dropColumn('pesan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            //
        });
    }
};
