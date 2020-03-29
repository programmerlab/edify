<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErrorLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('error_logs', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('url', 65535)->nullable();
			$table->text('message', 65535)->nullable();
			$table->string('error_type')->nullable();
			$table->text('file', 65535)->nullable();
			$table->string('statusCode')->nullable();
			$table->text('log')->nullable();
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
		Schema::drop('error_logs');
	}

}
