<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEditorProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('editor_profiles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title')->nullable();
			$table->text('slug', 65535)->nullable();
			$table->float('price', 10)->default(0.00);
			$table->integer('category_name')->nullable();
			$table->integer('software_editor')->nullable();
			$table->string('image_name')->nullable();
			$table->text('image_base_url', 65535)->nullable();
			$table->text('description', 65535)->nullable();
			$table->integer('editor_id')->nullable();
			$table->integer('customer_id')->nullable();
			$table->timestamps();
			$table->integer('total_likes')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('editor_profiles');
	}

}
