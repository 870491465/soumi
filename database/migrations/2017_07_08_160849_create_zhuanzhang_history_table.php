<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZhuanzhangHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('zhuanzhang_historys', function(Blueprint $table) {
           $table->increments('id');
            $table->integer('account_id');
            $table->decimal('amount');
            $table->integer('collection_account');
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
        Schema::drop('zhuanzhang_historys');
    }
}
