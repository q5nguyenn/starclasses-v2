<?php
namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait ResetAutoIncrement {
	public function resetAutoIncrement($table_name)
	{
		$sql = "ALTER TABLE $table_name AUTO_INCREMENT = 1";
		DB::statement($sql);
	}
}
	
?>