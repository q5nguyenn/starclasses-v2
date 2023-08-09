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
		Schema::create('chapters', function (Blueprint $table) {
			$table->id();
			$table->string('content');
			$table->unsignedBigInteger('parent_id');
			$table->string('video_link');
			$table->unsignedBigInteger('course_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('chapters');
	}
};
