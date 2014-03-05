<?php
$title = "东北师范大学 2013 年 ACM 校赛注册 - 晋级列表";
include_once('init.php');
$sql = "select * from contestant where status = 3";
$result = mysql_query($sql ,$conn);
$cnt = 1;
while($row=mysql_fetch_array($result)) {
#	echo $row['email']."; ";
} 
include_once('end.php');
?>
