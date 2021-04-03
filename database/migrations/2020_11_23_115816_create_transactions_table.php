<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('transactions')) return;       //add this line to migration file

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('is_for');
            $table->integer('amount');
            $table->json('meta')->nullable();//for extra data
            $table->string('track_code');
            $table->string('cardNumber');
            $table->bigInteger('ref_id')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('pay_way')->default(false);
            $table->ipAddress('ip')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
