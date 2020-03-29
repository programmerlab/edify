<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSupportConversationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('support_conversation', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('ticket_id')->nullable();
			$table->integer('parent_id')->nullable();
			$table->string('support_type')->nullable();
			$table->string('reason_type')->nullable();
			$table->integer('reply_by')->nullable();
			$table->text('user_comments', 65535)->nullable();
			$table->text('support_comments', 65535)->nullable();
			$table->string('email')->nullable();
			$table->string('subject')->nullable();
			$table->string('attachment')->nullable();
			$table->text('details', 65535)->nullable();
			$table->string('status')->nullable();
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
		Schema::drop('support_conversation');
	}

}
