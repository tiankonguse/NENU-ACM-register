<?php
require_once('init.php');
session_start();
$ret = array(
	"code" => 1,
	"message" => 'admin login first.'
);
if($_SESSION['ACMContestRegistAdmin']=='admin'){
	$id = intval($_POST['id']);
	$sql = "DELETE FROM contestant WHERE id = $id";
	mysql_query($sql);
	$ret['code'] = 0;
	$ret['message'] = '';
}
echo json_encode($ret);
require_once('end.php');
