<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        if(Schema::hasTable('banners')) return;      //to fix corrupted migrations bew wary for use
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('banner_position')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('place_id')->nullable();

            $table->string('title');
            $table->string('banners_url', 191)->nullable();

            $table->dateTime('expires_date')->nullable();
            $table->dateTime('start_date')->nullable();

            $table->boolean('active')->default(1);

            $table->string('type')->nullable();

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
        Schema::dropIfExists('banners');
    }
}
