<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbookAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_ebook', function (Blueprint $table) {
            $table->integer('author_id')->unsigned();
            $table->integer('ebook_id')->unsigned();

            $table->foreign('author_id')->references('id')->on('author');
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
