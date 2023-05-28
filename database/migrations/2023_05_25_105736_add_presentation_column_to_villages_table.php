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
        Schema::table('villages', function (Blueprint $table) {
            $table->after('photo_id', function ($table) {
                $table->unsignedBigInteger('presentation_id')->nullable();
            });
            $table->foreign('presentation_id')->references('id')->on('presentations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('villages', function (Blueprint $table) {
            $table->dropForeign(['presentation_id']);
            $table->dropColumn('presentation_id');
        });
    }
};
