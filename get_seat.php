<?php
session_start();
if($_SESSION['admin']!='admin'){
	header('Location:.');
	return;
}
include_once("init.php");

$res = mysql_query("SELECT * FROM contestant WHERE status = ".CONTEST_STATUS);
$cnt = mysql_num_rows($res);
$seats = array($cnt);
for($i = 0;$i < $cnt; $i++){
	$seats[$i] = $i + 1;
}
shuffle($seats);
$i = 0;
while($row = mysql_fetch_assoc($res)){
	mysql_query("UPDATE contestant SET seat = ".$seats[$i++]." WHERE id = ".$row['id']);
}
include_once("end.php");
header('Location:list.php');
