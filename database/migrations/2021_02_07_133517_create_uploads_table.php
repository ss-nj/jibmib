<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('uploads')) return;       //add this line to migration file

        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('reason')->nullable();
            $table->bigInteger('shop_id');
            $table->bigInteger('admin_id')->nullable();
            $table->string('src');
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
        Schema::dropIfExists('uploads');
    }
}
