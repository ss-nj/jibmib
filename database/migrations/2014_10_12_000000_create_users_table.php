<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('users')) return;       //add this line to migration file

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('mobile', 190);
            $table->string('email', 190)->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

            $table->string('password');

            $table->integer('city_id')->nullable();

            $table->string('verify_mobile_code')->nullable();
            $table->timestamp('mobile_verified_at')->default(now());

            $table->bigInteger('wallet')->default(0);
            $table->text('address')->nullable();

            $table->unsignedInteger('parent_id')->nullable();
            $table->string('affiliate_code', 190);

            $table->boolean('active')->default(1);

            $table->unique('mobile', 'mobile');
            $table->unique('affiliate_code', 'affiliate_code');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
