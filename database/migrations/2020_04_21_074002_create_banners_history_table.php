<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateBannersHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(Schema::hasTable('banners_history')) return;      //to fix corrupted migrations bew wary for use

        Schema::create('banners_history', function(Blueprint $table)
		{
            $table->id();
			$table->integer('banners_id')->index();
			$table->integer('banners_shown')->default(0);
			$table->integer('banners_clicked')->default(0);
			$table->dateTime('banners_history_date');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('banners_history');
	}

}
