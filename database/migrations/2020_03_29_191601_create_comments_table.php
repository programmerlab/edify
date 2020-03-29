<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('userId')->nullable();
			$table->integer('status')->default(1);
			$table->integer('editor_id')->nullable();
			$table->integer('commentId')->default(0);
			$table->integer('taskId')->nullable();
			$table->text('commentDescription')->nullable();
			$table->string('commentDate')->nullable();
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
		Schema::drop('comments');
	}

}
