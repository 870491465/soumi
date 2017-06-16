<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeclarationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('declarations', function(Blueprint $table) {
           $table->increments('id');
            $table->integer('account_id');
            $table->decimal('amount');
            $table->integer('status_id');
            $table->string('invoice_pic');
            $table->string('description')->nullable();
            $table->integer('balance_transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     *
     */
    public function down()
    {
        //
        Schema::drop('declarations');
    }
}
