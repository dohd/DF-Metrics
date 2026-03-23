<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToMemberlistItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memberlist_items', function (Blueprint $table) {
            $table->enum('category', ['local', 'diaspora', 'new'])->default('local');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memberlist_items', function (Blueprint $table) {
            $table->dropColumn(['category']);
        });
    }
}
