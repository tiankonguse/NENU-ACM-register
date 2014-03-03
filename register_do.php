<?php
session_start ();
$username = $_SESSION ['ACMContestRegistUsername'];
require_once ("init.php");
echo register ();
require_once ("end.php");
function output($id, $message) {
	$ret = array (
			'code' => $id,
			'message' => $message 
	);
	return json_encode ( $ret );
}
function register() {
	global $conn;
	global $username;
	
	$property = array (
			'username',
			'password',
			'password2',
			'realname',
			'department',
			'major',
			'grade',
			'student_id',
			'gender',
			'phone',
			'email',
			'qq' 
	);
	
	$num = count ( $property );
	
	for($i = 0; $i < $num; ++ $i) {
		if ($username != "" && ($property [$i] == 'password' || $property [$i] == 'password2'))
			continue;
		if (! isset ( $_POST [$property [$i]] )) {
			break;
		} else if ($_POST [$property [$i]] == "") {
			break;
		}
	}
	if ($i < $num) {
		return output ( ERROR, $property [$i] . " can't be null" );
	}
	if (strcmp ( $_POST ['password'], $_POST ['password2'] ) != 0) {
		return output ( ERROR, " two password is different" );
	}
	if (! preg_match ( '/^[0-9a-zA-Z_]{6,20}$/', $_POST ['password'] )) {
		return output ( ERROR, "Password should be between 6-20 and should be a-z,A-Z,-." );
	}
	
	if (! preg_match ( '/^[0-9]{11}$/', $_POST ['phone'] )) {
		return output ( ERROR, " phone is not correct,Should be 11 digits" );
	}
	if (! preg_match ( '/^[0-9]{6,15}$/', $_POST ['qq'] )) {
		return output ( ERROR, " qq is not correct,should be between 6-15" );
	}
	if (! preg_match ( '/^\d{6,20}$/', $_POST ['student_id'] )) {
		return output ( ERROR, " student id is not correct,should be between 6-20 " );
	}
	if (! preg_match ( '/^.+?@.+?\..+?$/', $_POST ['email'] )) {
		return output ( ERROR, " email is not correct" );
	}
	
	$password = sha1 ( SALT . $_POST ['password'] );
	$status = 0;
	$realname = mysql_real_escape_string ( $_POST ['realname'] );
	$department = mysql_real_escape_string ( $_POST ['department'] );
	$major = mysql_real_escape_string ( $_POST ['major'] );
	$grade = mysql_real_escape_string ( $_POST ['grade'] );
	$student_id = mysql_real_escape_string ( $_POST ['student_id'] );
	$gender = intval ( $_POST ['gender'] );
	$email = mysql_real_escape_string ( $_POST ['email'] );
	$phone = mysql_real_escape_string ( $_POST ['phone'] );
	$qq = mysql_real_escape_string ( $_POST ['qq'] );
	$register_time = time ();
	$remark = mysql_real_escape_string ( $_POST ['remark'] );
	
	if ($username != "") {
		// alter oneself information
		$result = mysql_query ( "SELECT status FROM contestant WHERE username = '$username'" );
		$row = mysql_fetch_assoc ( $result );
		if ($row ['status'] == 2) {
			if ($_POST ['password'] != "") {
				$sql .= "UPDATE contestant SET password = '$password' WHERE username = '$username'";
				mysql_query ( $sql );
				return output ( 0, "Password changed successfully" );
			} else {
				return output ( ERROR, "Password change fails" );
			}
		}
		$sql = "UPDATE contestant SET status = 0, realname = '$realname', department = '$department', major = '$major', grade = '$grade', gender = $gender, student_id = '$student_id', email = '$email', phone = '$phone', qq = '$qq', remark = '$remark'";
		if ($_POST ['password'] != "")
			$sql .= ", password = '$password'";
		$sql .= " WHERE username = '$username'";
		mysql_query ( $sql );
		return output ( SUCCESS, "Your personal information has been updated" );
	}
	
	$username = mysql_real_escape_string ( $_POST ['username'] );
	
	$sql = "select count(*) num from contestant where username = '$username'";
	
	$result = mysql_query ( $sql, $conn );
	$result = mysql_fetch_assoc ( $result );
	if ($result ["num"] > 0) {
		return output ( ERROR, "username is exist" );
	}
	
	$sql = "insert into contestant (username,password,status,realname,department,major,grade,student_id,gender,phone,qq,email,remark,register_time) values ('$username','$password',$status,'$realname','$department','$major','$grade','$student_id',$gender,'$phone','$qq','$email','$remark',$register_time)";
	
	$result = mysql_query ( $sql, $conn );
	if (! $result) {
		return output ( ERROR, "You submitted an error form!" );
	}
	$_SESSION ["ACMContestRegistUsername"] = $username;
	return output ( SUCCESS, "success" );
}

?>




