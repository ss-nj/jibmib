<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('messages')) return;       //add this line to migration file

        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('body');
            $table->unsignedInteger('ticket_id');
            $table->unsignedInteger('from_admin')->default(0);
            $table->unsignedInteger('user_id')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
