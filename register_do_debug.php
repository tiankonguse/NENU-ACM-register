<?php

session_start();
require_once("init.php");
echo register();
require_once("end.php");

function output($id, $message){
	$ret = array(
			'id' => $id,
			'message' => $message
		    );
	return json_encode($ret); 
}

function register(){
	global $conn;

	$proprety = array('username','password','password2','realname','department','major','grade','student_id','gender','phone','email','qq');

	$num = count($proprety); 

	for($i = 0; $i < $num; ++$i){ 
		if(!isset($_POST[$proprety[$i]])) {
			break;
		}else if(trim($_POST[$proprety[$i]]) == ""){
			break;
		}
	}
	if($i < $num){
		return output(1,$proprety[$i]."can't be null");
	}
	if(strcmp($_POST['password'],$_POST['password2']) != 0){
		return output(2,"two password is different");
	}
	if(!preg_match('/^[0-9]{11}$/',$_POST['phone'])) {
		return output(3,"phone is not correct");
	}
	if(!preg_match('/^[0-9]{6,15}$/',$_POST['qq'])) {
		return output(3,"qq is not correct");
	}
	if(!preg_match('/^.+?@.+?\..+?$/',$_POST['email'])) {
		return output(4,"email is not correct");
	}

	$username = mysql_real_escape_string($_POST['username']);

	$sql = "select * from contestant where username = '$username'";

	$result = mysql_query($sql ,$conn);

	if(mysql_num_rows($result) > 0){
		return output(5,"username is exist");
	}



	$password = sha1(SALT + mysql_real_escape_string($_POST['password']));
	$status = 0;
	$realname = mysql_real_escape_string($_POST['realname']);
	$department = mysql_real_escape_string($_POST['department']);
	$major = mysql_real_escape_string($_POST['major']);
	$grade = mysql_real_escape_string($_POST['grade']);
	$student_id = mysql_real_escape_string($_POST['student_id']);
	$gender = mysql_real_escape_string($_POST['gender']);
	$email  = mysql_real_escape_string($_POST['email']);
	$phone = mysql_real_escape_string($_POST['phone']);
	$qq = mysql_real_escape_string($_POST['qq']);
	$register_time = time();
	$remark = mysql_real_escape_string($_POST['remark']);

	$sql = "insert into contestant (username,password,status,realname,department,major,grade,student_id,gender,phone,qq,email,remark,register_time) values ('$username','$password',$status,'$realname','$department','$major','$grade','$student_id','$gender','$phone','$qq','$email','$remark',$register_time)";

	$result = mysql_query($sql ,$conn);

	if(!$result){
		return output(6,"You submitted an error form!");
	}

	return output(0,"success");
}

?>




