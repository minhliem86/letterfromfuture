<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique()->nullable();
			$table->string('student_account')->unique();
			$table->string('center_code')->nullable();
			$table->text('letter_content')->nullable();
			$table->text('letter_quote')->nullable();
			$table->string('fb_name')->nullable();
			$table->text('fb_img')->nullable();
			$table->string('img_upload')->nullable();
			$table->integer('age')->nullable();
			$table->integer('vote')->nullable();
			$table->boolean('joined')->default(0)->nullable();
			$table->integer('order')->nullable();
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
		Schema::drop('students');
	}

}
