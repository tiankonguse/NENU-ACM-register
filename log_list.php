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

$time = mktime(0,0,0);
$sql = "select  * from login_ip where time > $time";
//$sql = "select  * from login_ip where time in(Select max(time)   FROM login_ip group by username)"
$result = mysql_query($sql ,$conn);
$cnt = 0;
while($row=mysql_fetch_array($result)) {
$cnt++;
echo "
   <tr data-id='".$row['id']."' id='contestant_".$row['id']."'>
      <td>".$cnt."</td>
      <td>".$row['username']."</td>
      <td>".$row['ip']."</td>
      <td>".$row['real_ip']."</td>
      <td class='date_time'>".$row['time']."</td>
      <td>".$row['other']."</td>
   </tr>
";
 } ?>
 </tbody>
</table>
<p>共 <?php echo $cnt;?> 个记录</p>
<script src='js/jquery.tablesorter.min.js'></script>
<script>
Date.prototype.ojFormat=function(){
	function _(i){return i<10?"0"+i:""+i;}
	return this.getFullYear()+"-"+_(this.getMonth()+1)+"-"+_(this.getDate())+" "+_(this.getHours())+":"+_(this.getMinutes())+":"+_(this.getSeconds());
};
$(".date_time").each(function(){
	var d = new Date($(this).text()*1000);
	$(this).text(d.ojFormat());
});
</script>

<?php
include_once('footer.inc.php');
include_once('end.php');
?>
