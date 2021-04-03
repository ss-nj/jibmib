<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //صفحه مدیریت اسلایدر باید مشابه صفحه تعاریف باشد
    // یعنی یک طرف فرم و یک طرف نمایش شامل فیلد های عنوان اول عنوان دوم توضیحات تصویر متن دکمه و لینک دکمه
    public function up()
    {
        if(Schema::hasTable('sliders')) return;       //add this line to migration file
        Schema::create('sliders', function (Blueprint $table) {
            $table->string('name');
            $table->bigIncrements('id');
            $table->unsignedInteger('place_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('takhfif_id')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('expire_time')->nullable();
            $table->integer('position')->default(0);
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
        Schema::dropIfExists('sliders');
    }
}
