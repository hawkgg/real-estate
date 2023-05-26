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
                $table->unsignedBigInteger('estate_type_id')->nullable();
                $table->foreign('estate_type_id')->references('id')->on('estate_types');
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
            $table->dropForeign(['estate_type_id']);
            $table->dropColumn('estate_type_id');
        });
    }
};
