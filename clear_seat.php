<?php
session_start();
if($_SESSION['admin']!='admin'){
	header('Location:.');
	return;
}
include_once("init.php");
mysql_query("UPDATE contestant SET seat = '--'");
include_once("end.php");
header('Location:list.php');
