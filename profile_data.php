<?php
session_start();
$username = $_SESSION['ACMContestRegistUsername'];
if($username == ""){
	echo json_encode(array("code"=>1,"message"=>"login first!"));
	return;
}
require_once("init.php");
$result = mysql_query("SELECT * FROM contestant WHERE username = '$username'");
$row = mysql_fetch_assoc($result);
unset($row['password']);
echo json_encode(array(
	"code"=>0,
	"data"=>$row
)); 

include_once('end.php');

?>
