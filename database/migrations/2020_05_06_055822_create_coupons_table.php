<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        if(Schema::hasTable('coupons')) return;       //add this line to migration file
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->string('code');
            $table->integer('limit_on_discount')->nullable();
            $table->integer('limit_on_cart')->nullable();
            $table->integer('percent')->nullable();
            $table->integer('count')->nullable();
            $table->integer('amount')->nullable();
            $table->boolean('active')->default(1);
            $table->tinyInteger('type');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('expire_time')->nullable();
            $table->tinyInteger('effect_zone')->default(0);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
