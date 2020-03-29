<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEditorPostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('editor_post', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('eid');
			$table->string('before_img')->nullable();
			$table->string('after_img')->nullable();
			$table->string('software')->nullable();
			$table->string('comment')->nullable();
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
		Schema::drop('editor_post');
	}

}
