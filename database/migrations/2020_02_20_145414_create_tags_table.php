<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('tags')) return;       //add this line to migration file
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tagger_id')->nullable()->index();
            $table->string('tagger_type')->index()->nullable();
            $table->string('taggable_type');
            $table->string('taggable_id');
            $table->text('tag');
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
        Schema::dropIfExists('tags');
    }
}
