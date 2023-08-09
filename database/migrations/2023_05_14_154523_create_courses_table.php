<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('courses', function (Blueprint $table) {
			$table->id();
			$table->string('name', 350);
			$table->string('slug');
			$table->text('description');
			$table->float('price');
			$table->float('discount');
			$table->string('thumbnail', 500);
			$table->timestamps();
			$table->unsignedBigInteger('department_id');
			$table->unsignedBigInteger('teacher_id');
			$table->text('learn');
			$table->text('introduction');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('courses');
	}
};
