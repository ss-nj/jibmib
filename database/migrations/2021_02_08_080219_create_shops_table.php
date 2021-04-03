<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('shops')) return;       //add this line to migration file

        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('owner_name')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('category_id')->nullable();
            $table->string('lat')->nullable();
            $table->string('lang')->nullable();
            $table->string('province_id')->nullable();
            $table->string('city_id')->nullable();
            $table->text('address')->nullable();
            $table->bigInteger('place_id')->nullable();
            $table->text('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('uuid')->nullable();
            $table->string('isbn')->nullable();
            $table->string('bank_id')->nullable();
            $table->string('bank_account_owner_name')->nullable();
            $table->string('bank_account_owner_last_name')->nullable();
            $table->string('bank_account_type')->nullable();
            $table->timestamp('service_time')->nullable();
            $table->timestamp('service_week_days')->nullable();
            $table->tinyInteger('approved')->default(2);
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
        Schema::dropIfExists('shops');
    }
}
