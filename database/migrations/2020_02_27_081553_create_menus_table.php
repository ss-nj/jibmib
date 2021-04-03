<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('menus')) return;      //to fix coroupted migrations bew wary for use
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('menu')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('takhfif_id')->nullable();
            $table->string('name');
            $table->text('slug')->nullable();
            $table->text('link')->nullable();
            $table->string('icon')->nullable();
            $table->tinyInteger('type')->default('0');
            $table->integer('position')->nullable()->unsigned();
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('menus');
    }
}
