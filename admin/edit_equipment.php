<?php
include '../db_connect.php';
$qry = $conn->query("SELECT * FROM equipment_list where id = " . $_GET['id'])->fetch_array();
foreach ($qry as $k => $v) {
	$$k = $v;
}
$data = json_decode($data);

switch ($category_id) {
	case '1':
		include 'new_equipment_system_unit.php';
		break;
	case '2':
		include 'new_equipment_avr_monitor_keyboard.php';
		break;
	case '3':
		include 'new_equipment_avr_monitor_keyboard.php';
		break;
	case '4':
		include 'new_equipment_avr_monitor_keyboard.php';
		break;
	case '5':
		include 'new_equipment_tables.php';
		break;
	case '6':
		include 'new_equipment_monitor.php';
		break;
	case '7':
		include 'new_equipment_other_equipment.php';
		break;
	case '8':
		include 'new_equipment_monoblock_chairs.php';
		break;
}
