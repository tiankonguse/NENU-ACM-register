<?php
session_start();
$title = "东北师范大学 2013 年 ACM 校赛日志";
if($_SESSION['admin']!='admin'){
	header('Location:.');
	return;
}
include_once('init.php');
include_once('header.inc.php');
include('admin_menu.php');
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
	<th>操作</th>
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

	$username = $row['username'];
	$sql = "select distinct real_ip from login_ip where username = '$username' and time > $time";
	$result2 = mysql_query($sql ,$conn);
	if(mysql_num_rows($result2) != 1){
		$tr_class = "error";
	}else{
		$tr_class="success";
	}
echo "
   <tr data-id='".$row['id']."' id='contestant_".$row['id']."' class='$tr_class'>
      <td>".$cnt."</td>
      <td>".$row['username']."</td>
      <td>".$row['ip']."</td>
      <td>".$row['real_ip']."</td>
      <td class='date_time'>".$row['time']."</td>
      <td>".$row['other']."</td>
	<td><div class='btn btn-danger' onclick='del(".$row['id'].")'>删除</div></td>
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

$("table").addClass("tablesorter");
$("table").tablesorter({sortLocaleCompare:true});
$("th").attr("style","cursor:pointer;");
	

function del(id){
	if(confirm('你确定要删除 id = ' + id + '的这条日志吗？'))
	$.post(
		"log_delete.php",{
			id:id
		},function(d){
			if(d.code == 0){
				$("#contestant_"+id).remove();
			}else{
				showMessage(d.message);
			}
		},"json"
	);
}
</script>

<?php
include_once('footer.inc.php');
include_once('end.php');
?>
