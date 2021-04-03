<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpenTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('open_times')) return;       //add this line to migration file

        Schema::create('open_times', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shop_id');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('week_day');

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
        Schema::dropIfExists('open_times');
    }
}
