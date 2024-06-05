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
        Schema::table('events', function (Blueprint $table) {
            $table->tinyInteger('certificated')->after('published');
            $table->string('pesan')->after('certificated');
            $table->date('approve_date')->after('pesan');
            $table->unsignedBigInteger('approve_by')->after('approve_date');
            $table->unsignedBigInteger('partner_id')->after('approve_by');

            $table->foreign('approve_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};
