<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('ebook')) {
            return;
        }
        Schema::create('ebook', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->integer('rate');
            $table->string('link_content');
            $table->integer('pagenum');
            $table->string('image');
            $table->unsignedInteger('hire_price');
            $table->unsignedInteger('price');
            $table->tinyInteger('new');
            $table->integer('publisher_id');

            $table->foreign('publisher_id')->references('id')->on('publisher');

            $table->timestamp();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebook');
    }
}
