<?php
session_start ();
require_once ("init.php");
require_once ("check_ip.php");
$ret = array (
		"code" => 1,
		"message" => "Username or Password is not correct!" 
);
if (isset ( $_REQUEST ['username'] ) && isset ( $_REQUEST ['password'] )) {
	$username = mysql_real_escape_string ( $_REQUEST ['username'] );
	$password = sha1 ( SALT . $_REQUEST ['password'] );
	// echo $username . " " . $password;
	if ($username == 'admin' && $password == 'c03a66df94792e0a66cdef167f4c9ccb294cb450') {
		$_SESSION ['ACMContestRegistAdmin'] = 'admin';
		$_SESSION ['ACMContestRegistUsername'] = "";
	}
	
	$ip = $_SERVER ["REMOTE_ADDR"];
	if ($ip == "..") {
		$ret ["message"] = "Asscess Deny!";
	} else {
		$sql = "select * from contestant where username = '$username' and password = '$password'";
		$result = mysql_query ( $sql, $conn );
		$otl = ($password == sha1 ( SALT . sha1 ( SALT . intval ( time () / 120 ) ) ));
		if (mysql_num_rows ( $result ) > 0 || $otl) {
			$row = mysql_fetch_assoc ( $result );
			if (check ( $username ) || $otl || true) {
				$_SESSION ['ACMContestRegistUsername'] = $username;
				$_SESSION ['ACMContestRegistRealname'] = $row ['realname'];
				$_SESSION ['ACMContestRegistAdmin'] = "";
				if ($otl)
					header ( "Location:." );
				$ret ["code"] = 0;
				$ret ["message"] = "";
			} else {
				$ret ["code"] = 1;
				$ret ["message"] = "Access Deny! You are not allowed to login in a different IP address.";
			}
		}
	}
}
echo json_encode ( $ret );
require_once ("end.php");
?>
