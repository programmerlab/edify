<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEditorTestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('editor_test', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('eid')->nullable();
			$table->string('img1')->nullable();
			$table->string('img2')->nullable();
			$table->string('img3')->nullable();
			$table->string('img1_status')->nullable();
			$table->string('img2_status')->nullable();
			$table->string('img3_status')->nullable();
			$table->string('fb_id')->nullable();
			$table->string('insta_id')->nullable();
			$table->string('other_id')->nullable();
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
		Schema::drop('editor_test');
	}

}
