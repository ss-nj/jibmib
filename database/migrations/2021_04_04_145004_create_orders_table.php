<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('transaction_id')->index();
            $table->unsignedInteger('discount_code');
            $table->unsignedInteger('total_price');
            $table->unsignedInteger('total_discount');
            $table->string('card_number');
            $table->string('track_code');

            $table->tinyInteger('admin_seen');
            $table->tinyInteger('status')->default(2);
            $table->unsignedInteger('operator_id')->index();

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
        Schema::dropIfExists('orders');
    }
}
