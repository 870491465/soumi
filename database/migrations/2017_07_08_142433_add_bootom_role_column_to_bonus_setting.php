<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBootomRoleColumnToBonusSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('bonus_settings', function(Blueprint $table) {
           $table->integer('bottom_role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bonus_settings', function(Blueprint $table){
           $table->dropColumn('bottom_role');
        });
        //
    }
}
