<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //充值记录
        Schema::create('deposits', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->decimal('amount');
            $table->integer('status_id');
            $table->integer('upgrade_type_id')->default(0);
            $table->integer('deposit_type_id');
            $table->string('deposit_id');
            $table->string('transaction_id');
            $table->string('payment_method')->nullable();
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
        Schema::drop('deposits');
    }
}
