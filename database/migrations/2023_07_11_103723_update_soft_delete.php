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
		Schema::table('faculties', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('departments', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('courses', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('chapters', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('users', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('bills', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('reviews', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('sliders', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('codes', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('notifications', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('roles', function (Blueprint $table) {
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		//
	}
};
