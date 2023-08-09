<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
			DB::table('faculties')->insert([
				'name' => 'Foreign Language',
				'icon' => '<i class="bi bi-translate"></i>'
			]);
			DB::table('faculties')->insert([
					'name' => 'Marketing',
					'icon' => '<i class="bi bi-shop"></i>'
			]);
			DB::table('faculties')->insert([
					'name' => 'Office Informatics',
					'icon' => '<i class="bi bi-pc-display"></i>'
			]);
			DB::table('faculties')->insert([
					'name' => 'Design',
					'icon' => '<i class="bi bi-brush-fill"></i>'
			]);
			DB::table('faculties')->insert([
					'name' => 'Business and Startup',
					'icon' => '<i class="bi bi-graph-up-arrow"></i>'
			]);
			DB::table('faculties')->insert([
					'name' => 'Soft skills',
					'icon' => '<i class="bi bi-lightbulb"></i>'
			]);
			DB::table('faculties')->insert([
					'name' => 'Sales',
					'icon' => '<i class="bi bi-cart-check-fill"></i>'
			]);
			DB::table('faculties')->insert([
					'name' => 'Information technology',
					'icon' => '<i class="bi bi-code-slash"></i>'
			]);
			DB::table('faculties')->insert([
					'name' => 'Health and Gender',
					'icon' => '<i class="bi bi-house-heart-fill"></i>'
			]);
			DB::table('faculties')->insert([
					'name' => 'Lifestyle',
					'icon' => '<i class="bi bi-cup-hot-fill"></i>'
			]);
			DB::table('faculties')->insert([
				'name' => 'Raise up child',
				'icon' => '<i class="bi bi-person-check-fill"></i>'
		]);
			DB::table('faculties')->insert([
					'name' => 'Marriage and Family',
					'icon' => '<i class="bi bi-people-fill"></i>'
			]);
			DB::table('faculties')->insert([
					'name' => 'Photography and Editing',
					'icon' => '<i class="bi bi-camera-fill"></i>'
			]);
    }
}
