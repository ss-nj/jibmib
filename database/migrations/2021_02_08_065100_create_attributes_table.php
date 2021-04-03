<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('attributes')) return;       //add this line to migration file

        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('validation_unit')->nullable();//
            $table->integer('validation_length')->nullable();
            $table->string('field_type');
            $table->integer('position')->nullable();
            $table->boolean('active')->default(1);
            $table->text('description')->nullable();
            $table->enum('multiple',['0','1']);
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
        Schema::dropIfExists('atributes');
    }
}
