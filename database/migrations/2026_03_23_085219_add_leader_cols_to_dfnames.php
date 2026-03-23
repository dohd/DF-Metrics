<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeaderColsToDfnames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dfnames', function (Blueprint $table) {
            $table->string('leader')->nullable();
            $table->string('assistant_leader')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dfnames', function (Blueprint $table) {
            $table->dropColumn(['leader', 'assistant_leader']);
        });
    }
}
