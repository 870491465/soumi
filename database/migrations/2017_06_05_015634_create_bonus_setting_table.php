<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  权益设置
        Schema::create('bonus_settings', function(Blueprint $table) {
           $table->increments('id');
            $table->integer('primary_role')->default(0);
            $table->integer('agent_role')->default(0);
            $table->string('name')->nullable();
            $table->integer('deposit_type_id')->default(0);
            $table->integer('level');
            $table->integer('is_rate')->default(0);
            $table->decimal('rate');
            $table->integer('is_fixed')->default(0);
            $table->decimal('fixed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('bonus_settings');
    }
}
