<?php
session_start();
require_once("init.php");
$ret = array(
	"code" => 1,
	"message" => "Username or Password is not correct!"
);
if(isset($_POST['username']) && isset($_POST['password'])){
	$username = mysql_real_escape_string($_POST['username']);
	$password = sha1(SALT . $_POST['password']);
#	echo $username . " " . $password;
	if($username == 'admin' && $password == 'c03a66df94792e0a66cdef167f4c9ccb294cb450' ){
		$_SESSION['ACMContestRegistAdmin'] = 'admin';
		$_SESSION['ACMContestRegistUsername'] = "";
	}
	$sql = "select * from contestant where username = '$username' and password = '$password'";
	$result = mysql_query($sql ,$conn);
	if(mysql_num_rows($result) > 0){
		$_SESSION['ACMContestRegistUsername'] = $username;
		$_SESSION['ACMContestRegistAdmin'] = "";
		$ret["code"] = 0;
		$ret["message"] = "";
	}
}
echo json_encode($ret);
require_once("end.php");
?>
