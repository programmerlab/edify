<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSoftwareEditorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('software_editors', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('software_name')->nullable();
			$table->string('slug')->nullable();
			$table->string('description')->nullable();
			$table->string('image_name')->nullable();
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
		Schema::drop('software_editors');
	}

}
