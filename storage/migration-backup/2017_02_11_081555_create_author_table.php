<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('author',function(Blueprint $table){
			$table->integer('id');
			$table->string('realname',15);
			$table->string('workplace',63);
			$table->unsignedInteger('book_id'); // 图书的ISBN号

			$table->foreign('book_id')->references('id')->on('book');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('author');
	}
}