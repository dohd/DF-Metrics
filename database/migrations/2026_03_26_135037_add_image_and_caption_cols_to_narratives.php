<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageAndCaptionColsToNarratives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('narratives', function (Blueprint $table) {
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('caption1')->nullable();
            $table->string('caption2')->nullable();
            $table->string('caption3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('narratives', function (Blueprint $table) {
            $table->dropColumn(['image1', 'image2', 'image3', 'caption1', 'caption2', 'caption3']);
        });
    }
}
