<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('comments')) return;       //add this line to migration file
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('commenter_id')->nullable()->index();
            $table->string('commenter_type')->index()->nullable();
            $table->string('commentable_type');
            $table->string('commentable_id');
            $table->text('name');
            $table->text('title');
            $table->text('comment');
            $table->text('answer')->nullable();
            $table->timestamp('answer_time')->nullable();
            $table->integer('language_id')->default('1');
            $table->boolean('approved')->default(false);
            $table->unsignedBigInteger('child_id')->nullable();
            $table->unsignedBigInteger('operator_id')->nullable();
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
        Schema::dropIfExists('comments');
    }
}
