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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->text('bukti_pemb')->nullable();
            $table->text('bukti_pemb2')->nullable();
            $table->string('keterangan_admin')->nullable();
            $table->string('keterangan_user')->nullable();
            $table->string('pesan')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('id')->references('id')->on('registrasi_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
