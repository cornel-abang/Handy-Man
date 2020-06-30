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
            $table->timestamps();
            $table->integer('category_id');
            $table->integer('user_id');
            $table->integer('artisan_id')->unsigned()->nullable();
            $table->string('state');
            $table->string('local_govt');
            $table->string('street_addr');
            $table->datetime('visiting_date');
            $table->string('status')->default('New');
            $table->foreign('artisan_id')->references('id')->on('artisans');
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
