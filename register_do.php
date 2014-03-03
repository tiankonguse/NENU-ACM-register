<?php
session_start();
$username = $_SESSION['username'];
require_once("init.php");
echo register();
require_once("end.php");

function output($id, $message){
	$ret = array(
			'code' => $id,
			'message' => $message
		    );
	return json_encode($ret); 
}

function register(){
	global $conn;
	global $username;

	$property = array('username','password','password2','realname','department','major','grade','student_id','gender','phone','email','qq');

	$num = count($property); 

	for($i = 0; $i < $num; ++$i){ 
		if($username != "" && ($property[$i] == 'password' || $property[$i] == 'password2') )continue;
		if(!isset($_POST[$property[$i]])) {
			break;
		}else if($_POST[$property[$i]] == ""){
			break;
		}
	}
	if($i < $num){
		return output(1,$property[$i]." can't be null");
	}
	if(strcmp($_POST['password'],$_POST['password2']) != 0){
		return output(2," two password is different");
	}
	if(!preg_match('/^[0-9]{11}$/',$_POST['phone'])) {
		return output(3," phone is not correct");
	}
	if(!preg_match('/^[0-9]{6,15}$/',$_POST['qq'])) {
		return output(3," qq is not correct");
	}
	if(!preg_match('/^\d{6,20}$/',$_POST['student_id'])) {
		return output(3," student id is not correct");
	}
	if(!preg_match('/^.+?@.+?\..+?$/',$_POST['email'])) {
		return output(4," email is not correct");
	}

	$password = sha1(SALT . $_POST['password']);
	$status = 0;
	$realname = mysql_real_escape_string($_POST['realname']);
	$department = mysql_real_escape_string($_POST['department']);
	$major = mysql_real_escape_string($_POST['major']);
	$grade = mysql_real_escape_string($_POST['grade']);
	$student_id = mysql_real_escape_string($_POST['student_id']);
	$gender = intval($_POST['gender']);
	$email  = mysql_real_escape_string($_POST['email']);
	$phone = mysql_real_escape_string($_POST['phone']);
	$qq = mysql_real_escape_string($_POST['qq']);
	$register_time = time();
	$remark = mysql_real_escape_string($_POST['remark']);

	if($username != ""){
		$result = mysql_query("SELECT status FROM contestant WHERE username = '$username'");
		$row = mysql_fetch_assoc($result);
		if($row['status'] == 2){
			if($_POST['password']!=""){
				$sql.="UPDATE contestant SET password = '$password' WHERE username = '$username'";	
				mysql_query($sql);
				return output(0,"鎮ㄧ殑瀵嗙爜淇敼鎴愬姛銆�");
			}else{
				return output(5,"鎮ㄥ彧鍙互淇敼鎮ㄧ殑瀵嗙爜锛�");
			}
		}
		$sql = "UPDATE contestant SET status = 0, realname = '$realname', department = '$department', major = '$major', grade = '$grade', gender = $gender, student_id = '$student_id', email = '$email', phone = '$phone', qq = '$qq', remark = '$remark'";
		if($_POST['password']!="")
			$sql.=", password = '$password'";	
		$sql.=" WHERE username = '$username'";	
#		echo $sql.$_POST['password'];
		mysql_query($sql);
		return output(0,"鎮ㄧ殑淇℃伅淇敼鎴愬姛锛�");
	}

	$username = mysql_real_escape_string($_POST['username']);

	$sql = "select * from contestant where username = '$username'";

	$result = mysql_query($sql ,$conn);

	if(mysql_num_rows($result) > 0){
		return output(5,"username is exist");
	}




	$sql = "insert into contestant (username,password,status,realname,department,major,grade,student_id,gender,phone,qq,email,remark,register_time) values ('$username','$password',$status,'$realname','$department','$major','$grade','$student_id',$gender,'$phone','$qq','$email','$remark',$register_time)";

	$result = mysql_query($sql ,$conn);

	if(!$result){
		return output(6,"You submitted an error form!");
	}
	$_SESSION['username'] = $username;
	return output(0,"success");
}

?>




