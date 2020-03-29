<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title')->nullable();
			$table->text('page_content', 65535)->nullable();
			$table->text('slug', 65535)->nullable();
			$table->text('url', 65535)->nullable();
			$table->string('meta_title')->nullable();
			$table->text('meta_key', 65535)->nullable();
			$table->text('meta_description', 65535)->nullable();
			$table->string('images')->nullable();
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
		Schema::drop('pages');
	}

}
