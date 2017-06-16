<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('accounts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('business_name')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('license_no')->nullable(); //营业执照编号
            $table->string('person_name')->nullable(); //姓名
            $table->string('person_sex')->nullable();
            $table->string('identity_card')->nullable();
            $table->string('mobile');
            $table->string('license_pic')->nullable();
            $table->string('identity_card_pic')->nullable();
            $table->integer('status')->default(0);
            $table->integer('bank_id')->nullable();
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
        Schema::drop('accounts');
    }
}
