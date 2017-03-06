<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VoteStudent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vote_student', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('vote_id')->unsigned();
			$table->foreign('vote_id')->references('id')->on('votes')->onDelete('cascade');

			$table->integer('student_id')->unsigned();
			$table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
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
		Schema::drop('vote_student');
	}

}
