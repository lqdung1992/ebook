<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbookLangaugeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_ebook', function (Blueprint $table) {
            $table->integer('language_id');
            $table->integer('ebook_id');

            $table->foreign('language_id')->references('id')->on('language');
            $table->foreign('ebook_id')->references('id')->on('ebook');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
