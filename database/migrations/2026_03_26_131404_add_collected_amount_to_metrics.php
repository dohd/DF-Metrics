<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollectedAmountToMetrics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('metrics', function (Blueprint $table) {
            $table->decimal('collected_amount', 16, 4)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('metrics', function (Blueprint $table) {
            $table->dropColumn(['collected_amount']);
        });
    }
}
