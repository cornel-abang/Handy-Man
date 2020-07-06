<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category');
            $table->integer('user_id')->unsigned();
            $table->integer('artisan_id')->unsigned()->nullable();
            $table->string('state');
            $table->string('local_govt');
            $table->string('street_addr');
            $table->string('description');
            $table->string('status')->default('New');
            $table->timestamp('visiting_date');
            $table->timestamps();
            $table->foreign('artisan_id')->references('id')->on('artisans');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
