<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbookTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_ebook', function (Blueprint $table) {
            $table->integer('type_id');
            $table->integer('ebook_id');

            $table->foreign('type_id')->references('id')->on('type');
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
