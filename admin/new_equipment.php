<?php
$rooms = $conn->query("SELECT * FROM room_list order by id asc");
$category_list = array(
	1 => 'System Unit',
	2 => 'Monitor',
	3 => 'Avr',
	4 => 'Keyboard',
	5 => 'Mouse',
	6 => 'Monoblock Chairs',
	7 => 'Tables',
	8 => 'Other Equipment'
);
if (isset($_GET['room_id'])) {
	$room_name = $conn->query("SELECT * FROM room_list where id = " . $_GET['room_id'])->fetch_assoc()['room'];
}
?>
<?php if (!isset($_GET['room_id'])) { ?>
	<div class="form-group">
		<label for="room_id" class="control-label">
			Select Room
		</label>
		<select name="room_id" id="room_id" onchange="setQueryParams(this.value, 'room_id')" class="custom-select custom-select-sm">
			<option selected disabled>Select Room</option>
			<?php while ($row = $rooms->fetch_assoc()) : ?>
				<option value="<?= $row['id'] ?>" <?= isset($_GET['room_id']) && $_GET['room_id'] == $row['id'] ? 'selected' : '' ?>><?= $row['room'] ?></option>
			<?php endwhile; ?>
		</select>
	</div>
<?php } elseif (isset($_GET['room_id']) && !isset($_GET['category_name'])) {
	echo "<a href='./index.php?page=new_equipment' class='link'>Back</a>";
	echo "<h3>Room: <strong>" . $room_name . "</strong></h3>";
?>
	<div class="form-group">
		<label for="category_name" class="control-label">
			Select Category
		</label>
		<select name="category_name" id="category_name" onchange="setQueryParams(this.value, 'category_name')" class="custom-select custom-select-sm">
			<option selected disabled>Select Category</option>
			<?php foreach ($category_list as $key => $value) : ?>
				<option value="<?= $value ?>" <?= isset($_GET['category_name']) && $_GET['category_name'] == $key ? 'selected' : '' ?>><?= $value ?></option>
			<?php endforeach; ?>
		</select>
	</div>
<?php } ?>
<?php if (isset($_GET['room_id']) && isset($_GET['category_name'])) {
	echo "<a href='./index.php?page=new_equipment&room_id=" . $_GET['room_id'] . "' class='link'>Back</a>";
	echo "<h3>Room: <strong>" . $room_name . "</strong></h3>";
	echo "<h3>Category: <strong>" . $_GET['category_name'] . "</strong></h3><hr>";
	$eq_id = isset($_GET['eq_id']) ? $_GET['eq_id'] : '';

	if ($eq_id != '') {
		$qry = $conn->query("SELECT * FROM equipment_list where id = " . $_GET['eq_id'])->fetch_array();
		foreach ($qry as $k => $v) {
			$$k = $v;
		}

		$data = json_decode($data);

		$pc_number = isset($data->pc_number) ? $data->pc_number : '';
		$manufacturer = isset($data->manufacturer) ? $data->manufacturer : '';
		$serial_no = isset($data->serial_no) ? $data->serial_no : '';
		$os_version = isset($data->os_version) ? $data->os_version : '';
		$ram = isset($data->ram) ? $data->ram : '';
		$processor = isset($data->processor) ? $data->processor : '';
		$smart_tv = isset($data->smart_tv) ? $data->smart_tv : '';
		$monitor_number = isset($data->monitor_number) ? $data->monitor_number : '';
		$keyboard = isset($data->keyboard) ? $data->keyboard : '';
		$mouse = isset($data->mouse) ? $data->mouse : '';
		$avr = isset($data->avr) ? $data->avr : '';
		$switch = isset($data->switch) ? $data->switch : '';
		$air_condition_unit = isset($data->air_condition_unit) ? $data->air_condition_unit : '';
		$printer = isset($data->printer) ? $data->printer : '';
		$long = isset($data->long) ? $data->long : '';
		$square = isset($data->square) ? $data->square : '';
		$circle = isset($data->circle) ? $data->circle : '';
		$mini = isset($data->mini) ? $data->mini : '';
		$green = isset($data->green) ? $data->green : '';
		$white = isset($data->white) ? $data->white : '';
		$yellow = isset($data->yellow) ? $data->yellow : '';
		$arm_chair = isset($data->arm_chair) ? $data->arm_chair : '';
		$functional = isset($data->functional) ? $data->functional : '';
		$not_functional = isset($data->not_functional) ? $data->not_functional : '';
		$status = isset($data->status) ? $data->status : '';
	}

	switch ($_GET['category_name']) {
		case $category_list[1]:
			include 'new_equipment_system_unit.php';
			break;
		case $category_list[2]:
			include 'new_equipment_monitor.php';
			break;
		case $category_list[3]:
			include 'new_equipment_avr_monitor_keyboard.php';
			break;
		case $category_list[4]:
			include 'new_equipment_avr_monitor_keyboard.php';
			break;
		case $category_list[5]:
			include 'new_equipment_avr_monitor_keyboard.php';
			break;
		case $category_list[6]:
			include 'new_equipment_monoblock_chairs.php';
			break;
		case $category_list[7]:
			include 'new_equipment_tables.php';
			break;
		case $category_list[8]:
			include 'new_equipment_other_equipment.php';
			break;
	} ?>
<?php } ?>

<script>
	function setQueryParams(key, queryName) {
		const url = new URL(window.location.href);
		let current_location_ids = `${url}&${queryName}=${key}`
		url.searchParams.set(queryName, key)
		window.location.replace(current_location_ids)
	}
</script>