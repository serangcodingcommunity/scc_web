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
            $table->dropForeign('narasumber_id');
            $table->dropForeign('nid_1');
            $table->dropForeign('nid_2');
            $table->dropForeign('nid_3');
            $table->dropForeign('nid_4');
            $table->dropForeign('nid_5');
            $table->dropForeign('nid_6');
            $table->dropColumn('narasumber_id');
            $table->dropColumn('nid_1');
            $table->dropColumn('nid_2');
            $table->dropColumn('nid_3');
            $table->dropColumn('nid_4');
            $table->dropColumn('nid_5');
            $table->dropColumn('nid_6');
            $table->unsignedBigInteger('nid_1')->nullable();
            $table->unsignedBigInteger('nid_2')->nullable();
            $table->unsignedBigInteger('nid_3')->nullable();
            $table->unsignedBigInteger('nid_4')->nullable();
            $table->unsignedBigInteger('nid_5')->nullable();
            $table->unsignedBigInteger('nid_6')->nullable();

            $table->foreign('nid_1')->references('id')->on('narasumbers')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign('nid_2')->references('id')->on('narasumbers')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign('nid_3')->references('id')->on('narasumbers')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign('nid_4')->references('id')->on('narasumbers')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign('nid_5')->references('id')->on('narasumbers')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign('nid_6')->references('id')->on('narasumbers')->noActionOnDelete()->noActionOnUpdate();
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
