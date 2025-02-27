<?php
session_start();
ini_set('display_errors', 1);
class Action
{
	private $db;

	public function __construct()
	{
		ob_start();
		include 'db_connect.php';

		$this->db = $conn;
	}
	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}

	function login()
	{
		extract($_POST);
		$type = array("", "users", "faculty_list", "student_list");
		$type2 = array("", "admin", "faculty", "student");
		$qry = $this->db->query("SELECT *,concat(firstname,' ',lastname) as name FROM {$type[$login]} where email = '" . $email . "' and password = '" . md5($password) . "'  ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'password' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			$_SESSION['login_type'] = $login;
			$_SESSION['login_view_folder'] = $type2[$login] . '/';
			$academic = $this->db->query("SELECT * FROM academic_list where is_default = 1 ");
			if ($academic->num_rows > 0) {
				foreach ($academic->fetch_array() as $k => $v) {
					if (!is_numeric($k))
						$_SESSION['academic'][$k] = $v;
				}
			}
			return 1;
		} else {
			return 2;
		}
	}
	function logout()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function login2()
	{
		extract($_POST);
		$qry = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM students where student_code = '" . $student_code . "' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'password' && !is_numeric($key))
					$_SESSION['rs_' . $key] = $value;
			}
			return 1;
		} else {
			return 3;
		}
	}
	function save_user()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'cpass', 'password')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		if (!empty($password)) {
			$data .= ", password=md5('$password') ";
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}
		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
			$data .= ", avatar = '$fname' ";
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO users set $data");
		} else {
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if ($save) {
			return 1;
		}
	}
	function signup()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'cpass')) && !is_numeric($k)) {
				if ($k == 'password') {
					if (empty($v))
						continue;
					$v = md5($v);
				}
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}

		$check = $this->db->query("SELECT * FROM users where email ='$email' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}
		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
			$data .= ", avatar = '$fname' ";
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO users set $data");
		} else {
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if ($save) {
			if (empty($id))
				$id = $this->db->insert_id;
			foreach ($_POST as $key => $value) {
				if (!in_array($key, array('id', 'cpass', 'password')) && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			$_SESSION['login_id'] = $id;
			if (isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
				$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}

	function update_user()
	{
		extract($_POST);
		$data = "";
		$type = array("", "users", "faculty_list", "student_list");
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'cpass', 'table', 'password')) && !is_numeric($k)) {

				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM {$type[$_SESSION['login_type']]} where email ='$email' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}
		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
			$data .= ", avatar = '$fname' ";
		}
		if (!empty($password))
			$data .= " ,password=md5('$password') ";
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO {$type[$_SESSION['login_type']]} set $data");
		} else {
			echo "UPDATE {$type[$_SESSION['login_type']]} set $data where id = $id";
			$save = $this->db->query("UPDATE {$type[$_SESSION['login_type']]} set $data where id = $id");
		}

		if ($save) {
			foreach ($_POST as $key => $value) {
				if ($key != 'password' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			if (isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
				$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}
	function delete_user()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = " . $id);
		if ($delete)
			return 1;
	}
	function save_system_settings()
	{
		extract($_POST);
		$data = '';
		foreach ($_POST as $k => $v) {
			if (!is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		if ($_FILES['cover']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['cover']['name'];
			$move = move_uploaded_file($_FILES['cover']['tmp_name'], '../assets/uploads/' . $fname);
			$data .= ", cover_img = '$fname' ";
		}
		$chk = $this->db->query("SELECT * FROM system_settings");
		if ($chk->num_rows > 0) {
			$save = $this->db->query("UPDATE system_settings set $data where id =" . $chk->fetch_array()['id']);
		} else {
			$save = $this->db->query("INSERT INTO system_settings set $data");
		}
		if ($save) {
			foreach ($_POST as $k => $v) {
				if (!is_numeric($k)) {
					$_SESSION['system'][$k] = $v;
				}
			}
			if ($_FILES['cover']['tmp_name'] != '') {
				$_SESSION['system']['cover_img'] = $fname;
			}
			return 1;
		}
	}
	function save_image()
	{
		extract($_FILES['file']);
		if (!empty($tmp_name)) {
			$fname = strtotime(date("Y-m-d H:i")) . "_" . (str_replace(" ", "-", $name));
			$move = move_uploaded_file($tmp_name, 'assets/uploads/' . $fname);
			$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';
			$hostName = $_SERVER['HTTP_HOST'];
			$path = explode('/', $_SERVER['PHP_SELF']);
			$currentPath = '/' . $path[1];
			if ($move) {
				return $protocol . '://' . $hostName . $currentPath . '/assets/uploads/' . $fname;
			}
		}
	}
	function save_subject()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'user_ids')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		$chk = $this->db->query("SELECT * FROM subject_list where code = '$code' and id != '{$id}' ")->num_rows;
		if ($chk > 0) {
			return 2;
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO subject_list set $data");
		} else {
			$save = $this->db->query("UPDATE subject_list set $data where id = $id");
		}
		if ($save) {
			return 1;
		}
	}
	function delete_subject()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM subject_list where id = $id");
		if ($delete) {
			return 1;
		}
	}
	function save_class()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'user_ids')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		$chk = $this->db->query("SELECT * FROM class_list where (" . str_replace(",", 'and', $data) . ") and id != '{$id}' ")->num_rows;
		if ($chk > 0) {
			return 2;
		}
		if (isset($user_ids)) {
			$data .= ", user_ids='" . implode(',', $user_ids) . "' ";
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO class_list set $data");
		} else {
			$save = $this->db->query("UPDATE class_list set $data where id = $id");
		}
		if ($save) {
			return 1;
		}
	}
	function delete_class()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM class_list where id = $id");
		if ($delete) {
			return 1;
		}
	}
	function save_academic()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'user_ids')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		$chk = $this->db->query("SELECT * FROM academic_list where (" . str_replace(",", 'and', $data) . ") and id != '{$id}' ")->num_rows;
		if ($chk > 0) {
			return 2;
		}
		$hasDefault = $this->db->query("SELECT * FROM academic_list where is_default = 1")->num_rows;
		if ($hasDefault == 0) {
			$data .= " , is_default = 1 ";
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO academic_list set $data");
		} else {
			$save = $this->db->query("UPDATE academic_list set $data where id = $id");
		}
		if ($save) {
			return 1;
		}
	}
	function delete_academic()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM academic_list where id = $id");
		if ($delete) {
			return 1;
		}
	}
	function make_default()
	{
		extract($_POST);
		$update = $this->db->query("UPDATE academic_list set is_default = 0");
		$update1 = $this->db->query("UPDATE academic_list set is_default = 1 where id = $id");
		$qry = $this->db->query("SELECT * FROM academic_list where id = $id")->fetch_array();
		if ($update && $update1) {
			foreach ($qry as $k => $v) {
				if (!is_numeric($k))
					$_SESSION['academic'][$k] = $v;
			}

			return 1;
		}
	}
	function save_criteria()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'user_ids')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		$chk = $this->db->query("SELECT * FROM criteria_list where (" . str_replace(",", 'and', $data) . ") and id != '{$id}' ")->num_rows;
		if ($chk > 0) {
			return 2;
		}

		if (empty($id)) {
			$lastOrder = $this->db->query("SELECT * FROM criteria_list order by abs(order_by) desc limit 1");
			$lastOrder = $lastOrder->num_rows > 0 ? $lastOrder->fetch_array()['order_by'] + 1 : 0;
			$data .= ", order_by='$lastOrder' ";
			$save = $this->db->query("INSERT INTO criteria_list set $data");
		} else {
			$save = $this->db->query("UPDATE criteria_list set $data where id = $id");
		}
		if ($save) {
			return 1;
		}
	}
	function delete_criteria()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM criteria_list where id = $id");
		if ($delete) {
			return 1;
		}
	}
	function save_criteria_order()
	{
		extract($_POST);
		$data = "";
		foreach ($criteria_id as $k => $v) {
			$update[] = $this->db->query("UPDATE criteria_list set order_by = $k where id = $v");
		}
		if (isset($update) && count($update)) {
			return 1;
		}
	}

	function save_question()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'user_ids')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}

		if (empty($id)) {
			$lastOrder = $this->db->query("SELECT * FROM question_list where academic_id = $academic_id order by abs(order_by) desc limit 1");
			$lastOrder = $lastOrder->num_rows > 0 ? $lastOrder->fetch_array()['order_by'] + 1 : 0;
			$data .= ", order_by='$lastOrder' ";
			$save = $this->db->query("INSERT INTO question_list set $data");
		} else {
			$save = $this->db->query("UPDATE question_list set $data where id = $id");
		}
		if ($save) {
			return 1;
		}
	}
	function delete_question()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM question_list where id = $id");
		if ($delete) {
			return 1;
		}
	}
	function save_question_order()
	{
		extract($_POST);
		$data = "";
		foreach ($qid as $k => $v) {
			$update[] = $this->db->query("UPDATE question_list set order_by = $k where id = $v");
		}
		if (isset($update) && count($update)) {
			return 1;
		}
	}
	function save_faculty()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'cpass', 'password')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		if (!empty($password)) {
			$data .= ", password=md5('$password') ";
		}
		$check = $this->db->query("SELECT * FROM faculty_list where email ='$email' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}
		$check = $this->db->query("SELECT * FROM faculty_list where school_id ='$school_id' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 3;
			exit;
		}
		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
			$data .= ", avatar = '$fname' ";
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO faculty_list set $data");
		} else {
			$save = $this->db->query("UPDATE faculty_list set $data where id = $id");
		}

		if ($save) {
			return 1;
		}
	}
	function delete_faculty()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM faculty_list where id = " . $id);
		if ($delete)
			return 1;
	}
	function save_student()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'cpass', 'password')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		if (!empty($password)) {
			$data .= ", password=md5('$password') ";
		}
		$check = $this->db->query("SELECT * FROM student_list where email ='$email' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}
		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
			$data .= ", avatar = '$fname' ";
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO student_list set $data");
		} else {
			$save = $this->db->query("UPDATE student_list set $data where id = $id");
		}

		if ($save) {
			return 1;
		}
	}
	function delete_student()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM student_list where id = " . $id);
		if ($delete)
			return 1;
	}
	function save_task()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_numeric($k)) {
				if ($k == 'description')
					$v = htmlentities(str_replace("'", "&#x2019;", $v));
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO task_list set $data");
		} else {
			$save = $this->db->query("UPDATE task_list set $data where id = $id");
		}
		if ($save) {
			return 1;
		}
	}
	function delete_task()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM task_list where id = $id");
		if ($delete) {
			return 1;
		}
	}
	function save_progress()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_numeric($k)) {
				if ($k == 'progress')
					$v = htmlentities(str_replace("'", "&#x2019;", $v));
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		if (!isset($is_complete))
			$data .= ", is_complete=0 ";
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO task_progress set $data");
		} else {
			$save = $this->db->query("UPDATE task_progress set $data where id = $id");
		}
		if ($save) {
			if (!isset($is_complete))
				$this->db->query("UPDATE task_list set status = 1 where id = $task_id ");
			else
				$this->db->query("UPDATE task_list set status = 2 where id = $task_id ");
			return 1;
		}
	}
	function delete_progress()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM task_progress where id = $id");
		if ($delete) {
			return 1;
		}
	}
	function save_restriction()
	{
		extract($_POST);
		$filtered = implode(",", array_filter($rid));
		if (!empty($filtered))
			$this->db->query("DELETE FROM restriction_list where id not in ($filtered) and academic_id = $academic_id");
		else
			$this->db->query("DELETE FROM restriction_list where  academic_id = $academic_id");
		foreach ($rid as $k => $v) {
			$data = " academic_id = $academic_id ";
			$data .= ", faculty_id = {$faculty_id[$k]} ";
			$data .= ", class_id = {$class_id[$k]} ";
			$data .= ", subject_id = {$subject_id[$k]} ";
			if (empty($v)) {
				$save[] = $this->db->query("INSERT INTO restriction_list set $data ");
			} else {
				$save[] = $this->db->query("UPDATE restriction_list set $data where id = $v ");
			}
		}
		return 1;
	}
	function save_evaluation()
	{
		extract($_POST);
		$data = " student_id = {$_SESSION['login_id']} ";
		$data .= ", academic_id = $academic_id ";
		$data .= ", subject_id = $subject_id ";
		$data .= ", class_id = $class_id ";
		$data .= ", restriction_id = $restriction_id ";
		$data .= ", faculty_id = $faculty_id ";
		$save = $this->db->query("INSERT INTO evaluation_list set $data");
		if ($save) {
			$eid = $this->db->insert_id;
			foreach ($qid as $k => $v) {
				$data = " evaluation_id = $eid ";
				$data .= ", question_id = $v ";
				$data .= ", rate = {$rate[$v]} ";
				$ins[] = $this->db->query("INSERT INTO evaluation_answers set $data ");
			}
			if (isset($ins))
				return 1;
		}
	}
	function get_class()
	{
		extract($_POST);
		$data = array();
		$get = $this->db->query("SELECT c.id,concat(c.curriculum,' ',c.level,' - ',c.section) as class,s.id as sid,concat(s.code,' - ',s.subject) as subj FROM restriction_list r inner join class_list c on c.id = r.class_id inner join subject_list s on s.id = r.subject_id where r.faculty_id = {$fid} and academic_id = {$_SESSION['academic']['id']} ");
		while ($row = $get->fetch_assoc()) {
			$data[] = $row;
		}
		return json_encode($data);
	}
	function get_report()
	{
		extract($_POST);
		$data = array();
		$get = $this->db->query("SELECT * FROM evaluation_answers where evaluation_id in (SELECT evaluation_id FROM evaluation_list where academic_id = {$_SESSION['academic']['id']} and faculty_id = $faculty_id and subject_id = $subject_id and class_id = $class_id ) ");
		$answered = $this->db->query("SELECT * FROM evaluation_list where academic_id = {$_SESSION['academic']['id']} and faculty_id = $faculty_id and subject_id = $subject_id and class_id = $class_id");
		$rate = array();
		while ($row = $get->fetch_assoc()) {
			if (!isset($rate[$row['question_id']][$row['rate']]))
				$rate[$row['question_id']][$row['rate']] = 0;
			$rate[$row['question_id']][$row['rate']] += 1;
		}
		// $data[]= $row;
		$ta = $answered->num_rows;
		$r = array();
		foreach ($rate as $qk => $qv) {
			foreach ($qv as $rk => $rv) {
				$r[$qk][$rk] = ($rate[$qk][$rk] / $ta) * 100;
			}
		}
		$data['tse'] = $ta;
		$data['data'] = $r;

		return json_encode($data);
	}
	function save_room()
	{
		extract($_POST);
		// foreach ($_POST as $key => $value) {
		// 	echo $key . " = " . $value . "<br>";
		// }
		$chk = $this->db->query("SELECT * FROM room_list where room = '$room' and id != '{$id}' ")->num_rows;
		if ($chk > 0) {
			return 2;
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO `room_list`(`room`, `description`, `capacity`, `status`) VALUES ('$room','$description','$capacity','$status')");
		} else {
			if (empty($faculty_id_1)) {
				$save = $this->db->query("UPDATE room_list SET `faculty_id_2`=$faculty_id_2 WHERE id = $id");
			} else if (empty($faculty_id_2)) {
				$save = $this->db->query("UPDATE room_list SET `faculty_id_1`=$faculty_id_1 WHERE id = $id");
			} else {
				$save = $this->db->query("UPDATE room_list SET `room`='$room', `description`='$description', `capacity`='$capacity', `status`='$status', `faculty_id_1`=$faculty_id_1, `faculty_id_2`=$faculty_id_2 WHERE id = $id");
			}
		}
		if ($save) {
			return 1;
		}
	}
	function delete_room()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM `room_list` WHERE id = $id");
		if ($delete) {
			return 1;
		}
	}

	function save_equipment()
	{
		extract($_POST);
		$data = array();
		foreach ($_POST as $key => $value) {
			if ($key != 'room_id' || $key != 'equipment_id') {
				$data[$key] = $value;
			}
		}
		$data_json = json_encode($data);
		if (empty($equipment_id)) {
			$save = $this->db->query("INSERT INTO `equipment_list`(`room_id`, `category_id`, `data`) VALUES ('$room_id', '$category_id','$data_json')");
		} else {
			$save = $this->db->query("UPDATE equipment_list SET `data`='$data_json' WHERE id = $equipment_id");
		}
		if ($save) {
			return 1;
		}
	}
	function delete_equipment()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM `equipment_list` WHERE id = $id");
		if ($delete) {
			return 1;
		}
	}

	function save_faculty_room()
	{
		extract($_POST);
		// foreach ($_POST as $key => $value) {
		// 	echo $key . " = " . $value . "<br>";
		// }
		$chk = $this->db->query("SELECT * FROM faculty_room_list where faculty_id = '$faculty_id' and room_id = '{$room_id}' ")->num_rows;
		if ($chk > 0) {
			return 2;
		}

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO `faculty_room_list`(`faculty_id`, `room_id`) VALUES ('$faculty_id','$room_id')");
		} else {
			$save = $this->db->query("UPDATE faculty_room_list set `faculty_id`='$faculty_id', `room_id`='$room_id' where id = $id");
		}
		if ($save) {
			return 1;
		}
	}

	function save_report_fa1()
	{
		extract($_POST);

		$user_id = $_SESSION['login_id'];

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO `tb_report`(`area`,`equipment`, `date`, `status`, `user_id`) VALUES ('$area','$equipment','$date','$status','$user_id')");
		} else {
			$save = $this->db->query("UPDATE tb_report set `area`='$area', `equipment`='$equipment', `date`='$date', `status`='$status', `user_id`='$user_id' where id = $id");
		}
		if ($save) {
			return 1;
		}
	}

	function delete_report_fa1()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM `tb_report` WHERE id = $id");
		if ($delete) {
			return 1;
		}
	}

	function save_report_fa()
	{
		extract($_POST);
		$faculty_id = $_SESSION['login_id'];

		$language = "";
		foreach ($languages as $row) {
			$language .= $row . ",";
		}

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO `tb_data`(`user_id`,`faculty_id`, `description`, `languages`,`req_no`) VALUES ('$user_id','$faculty_id','$description','$language','$req_no')");
		} else {
			$save = $this->db->query("UPDATE tb_data set `f_status`='$f_status' WHERE id = $id");
		}
		if ($save) {
			return 1;
		}
	}

	function save_report()
	{
		extract($_POST);
		$user_id = $_SESSION['login_id'];

		$language = "";
		foreach ($languages as $row) {
			$language .= $row . ",";
		}

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO `tb_data`(`user_id`, `description`, `languages`, `faculty_id`) VALUES ('$user_id','$description','$language','$faculty_id')");
		} else {
			$save = $this->db->query("UPDATE tb_data set `status`='$status' WHERE id = $id");
			if (empty($comments)) {
				$comments = "No comments";
			}
			$save = $this->db->query("INSERT INTO `tb_data_comments`(`comments`, `student_id`, `tb_data_id`) VALUES ('$comments','$user_id','$id')");
		}
		if ($save) {
			return 1;
		}
	}

	function delete_report()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM `tb_data` WHERE id = $id");
		if ($delete) {
			return 1;
		}
	}

	function save_evaluation_01()
	{
		extract($_POST);
		// var_dump($_POST);
		$user_id = $_SESSION['login_id'];

		// $chk = $this->db->query("SELECT * FROM tbl_evaluation where user_id = '$user_id' ")->num_rows;
		// if ($chk > 0) {
		// 	return 2;
		// }

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO `tbl_evaluation`(`user_id`, `report_id`, `service`, `response`, `quality`, `communication`, `experience`, `troubleshooting`, `clean_orderly`, `overall`, `core_services`, `improvement`) VALUES ('$user_id','$report_id','$service','$response','$quality','$communication','$experience','$troubleshooting','$clean_orderly','$overall','$core_services','$improvement')");

			$save = $this->db->query("UPDATE `tb_data` set `f_status`='1' where id = $report_id");
		} else {
			$save = $this->db->query("UPDATE tbl_evaluation set `c_status`='$status' where id = $id");
		}
		if ($save) {
			return 1;
		}
	}

	function delete_evaluation_01()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM `tbl_evaluation` WHERE id = $id");
		if ($delete) {
			return 1;
		}
	}
}
