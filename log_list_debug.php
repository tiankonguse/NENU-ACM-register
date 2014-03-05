<?php
session_start();
$title = "东北师范大学 2013 年 ACM 校赛日志";
if($_SESSION['admin']!='admin'){
	header('Location:.');
	return;
}
include_once('init.php');
include_once('header.inc.php');
?>

<table class="table table-striped table-bordered table-condensed tablesorter" style="word-break:break-all;">
<thead>
    <tr>
      <th>id</th>
      <th>username</th>
      <th>ip</th>
      <th>real ip</th>
      <th>time</th>
      <th>other</th>
    </tr>
  </thead>
  <tbody> 
<?php
$sql = "select  DISTINCT username from login_ip";
//$sql = "select  * from login_ip where time in(Select max(time)   FROM login_ip group by username)"
$result = mysql_query($sql ,$conn);
$cnt = 0;
$time = mktime(0,0,0);

while($row=mysql_fetch_array($result)) {
	$cnt++;

	$username = $row['username'];
	$sql = "select distinct real_ip from login_ip where username = '$username' and time > $time";
	$result2 = mysql_query($sql ,$conn);
	if(mysql_num_rows($result2) != 1){
		$tr_class = "error";
	}else{
		$tr_class="success";
	}

	while($row2=mysql_fetch_array($result2)) {

		//$sql = "select * from login_ip where username = '$username' and real_ip = ".$row2['real_ip']."";
		$real_ip = $row2['real_ip'];
		$sql = "select * from login_ip where username = '$username' and time > $time ";
		$result3 = mysql_query($sql ,$conn);

		$row3=mysql_fetch_array($result3);
		echo "
   <tr data-id='".$row3['id']."' id='contestant_".$row3['id']."' class='$tr_class'>
      <td>".$cnt."</td>
      <td>$username</td>
      <td>".$row3['ip']."</td>
      <td>$real_ip</td>
      <td class='date_time'>".$row3['time']."</td>
      <td>".$row3['other']."</td>
   </tr>
";

	}
 } ?>
 </tbody>
</table>
<p>共 <?php echo $cnt;?> 个记录</p>
<script src='js/jquery.tablesorter.min.js'></script>
<script>
$(".date_time").each(function(){
	var d = new Date($(this).text()*1000);
	$(this).text(d.ojFormat());
});
</script>

<?php
include_once('footer.inc.php');
include_once('end.php');
?>
