<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTakhfifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('takhfifs')) return;       //add this line to migration file

        Schema::create('takhfifs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('tags')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->timestamp('display_start_time')->nullable();
            $table->timestamp('display_end_time')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('expire_time')->nullable();
            $table->unsignedInteger('time_out')->nullable();
            $table->unsignedInteger('capacity')->default(0);
            $table->tinyInteger('vip')->default(0);
            $table->unsignedInteger('shop_id');
            $table->longText('description')->nullable();
            $table->tinyInteger('active')->default(0);
            $table->unsignedInteger('view_count')->default(0);
            $table->tinyInteger('approved')->default(0);
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('discount')->nullable();
            $table->unsignedInteger('discount_price')->nullable();

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
        Schema::dropIfExists('takhfifs');
    }
}
