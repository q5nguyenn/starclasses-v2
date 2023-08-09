<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('roles')->insert([
				'name' => 'admin',
				'description' => 'Super admim - q5nguyen@gmail.com'
			]);
			DB::table('roles')->insert([
				'name' => 'student',
				'description' => 'Sinh viên'
			]);
			DB::table('roles')->insert([
				'name' => 'teacher',
				'description' => 'Giảng viên'
			]);
			DB::table('roles')->insert([
				'name' => 'manager',
				'description' => 'Quản lý'
			]);

    }
}
