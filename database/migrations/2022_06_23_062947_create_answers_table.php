<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('examId')->unsigned();
            $table->integer('questionId')->unsigned();
            $table->string('title');
            $table->integer('order')->nullable();
            $table->boolean('status')->default(false);  // false refer to not correct answers
            $table->foreign('examId')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('questionId')->references('id')->on('questions')->onDelete('cascade');
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
        Schema::dropIfExists('answers');
    }
}
