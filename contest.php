<?php
include_once('init.php');
session_start();
$username = $_SESSION['username'];
if($username == ""){
	echo "Login first!";
	return;
}
if(!CONTEST_STARTED){
	echo "Contest is not started!";
	return;
}
$result = mysql_query("SELECT * FROM contestant WHERE username = '$username'");
$row = mysql_fetch_assoc($result);
if($row['status'] != CONTEST_STATUS){
	echo "You are not allowed to enter the contest!";
	return;
}
$nickname = "(".$row['grade']."#".$row['seat'].")".$row['realname']." ".$row['major'];
$timestamp = time() * 1000;
$tmp = $username.$nickname.$timestamp.CONTEST_SALT;
$token = md5($tmp);
header("Location:/judge/user/login.action?username=".rawurlencode($username)."&nickname=".rawurlencode($nickname)."&timestamp=$timestamp&token=$token");
include_once('end.php');
