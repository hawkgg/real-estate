<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->after('square', function ($table) {
                $table->unsignedBigInteger('default_currency_id')->nullable();
                $table->foreign('default_currency_id')->references('id')->on('currencies');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropForeign(['default_currency_id']);
            $table->dropColumn('default_currency_id');
        });
    }
};
