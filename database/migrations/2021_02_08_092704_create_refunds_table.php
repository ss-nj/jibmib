<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('refunds')) return;       //add this line to migration file

        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shop_id');
            $table->unsignedInteger('by_admin');
            $table->unsignedBigInteger('amount');
            $table->string('bank_id')->nullable();
            $table->text('description');
            $table->timestamp('approve_date')->nullable();
            $table->timestamp('pay_date')->nullable();
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
        Schema::dropIfExists('refunds');
    }
}
