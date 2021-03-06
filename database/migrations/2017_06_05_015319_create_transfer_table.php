<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('transfers', function(Blueprint $table) {
           $table->increments('id');
           $table->integer('account_id');
            $table->decimal('amount');
            $table->integer('account_bank_id');
            $table->integer('balance_transacion_id')->default(0);
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
        Schema::drop('transfers');
    }
}
