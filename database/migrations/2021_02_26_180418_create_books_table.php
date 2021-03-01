<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

   
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('isbn', 255);
            $table->text('authors');
            $table->integer('number_of_pages');
            $table->string('publisher', 255);
            $table->string('country', 70);
            $table->date('release_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}