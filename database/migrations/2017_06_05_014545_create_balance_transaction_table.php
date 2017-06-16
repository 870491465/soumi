<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //金额发生变化表
        Schema::create('balance_transactions', function(Blueprint $table) {
           $table->increments('id');
           $table->integer('account_id');
           $table->decimal('amount');
           $table->integer('balance_transaction_type_id');
           $table->integer('status_id');
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
        Schema::drop('balance_transactions');
    }
}
