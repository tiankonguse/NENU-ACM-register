<?php
session_start();
if($_SESSION['admin']!='admin'){
	header('Location:.');
	return;
}
$title = "东北师范大学 2013 年 ACM 校赛注册";
include_once('init.php');
include_once('header.inc.php');
$status = intval($_GET['status']);
?>
<p><?php foreach($status_description as $s => $d){
	echo "[<a href='?status=$s'>$d</a>] ";
} ?></p>
<table class="table table-striped table-bordered table-condensed tablesorter" style="word-break:break-all;">
  <tbody>
<?php
$sql = "select * from contestant where status = $status";
$result = mysql_query($sql ,$conn);
$cnt = 0;
while($row=mysql_fetch_array($result)) {
$cnt++;
echo "
   <tr data-id='".$row['id']."' id='contestant_".$row['id']."'><td>".$row['email']."</td>
   </tr>
";
 } ?>
  </tbody>
