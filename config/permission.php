<?php
	return [
		'access' => [
			'faculty-list' => 'faculty_list'
		],
		'table_modul' => [
			'faculty',
			'department',
		],
		'modul_child' => [
			'view',
			'create',
			'index',
			'delete'
		]
	]

	// để lấy ra giá trị thì dùng config('permission.access.faculty-list');
?>