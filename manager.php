<?php
session_start ();
if ($_SESSION ['ACMContestRegistAdmin'] != 'admin') {
	header ( 'Location:.' );
	return;
}
$title = "东北师范大学 " . date ( "Y", time () ) . "  年 ACM 校赛注册";
include_once ('init.php');
include_once ('header.inc.php');
$status = intval ( $_GET ['status'] );
include ('admin_menu.php');
?>
<table
	class="table table-striped table-bordered table-condensed tablesorter"
	style="word-break: break-all;">
	<thead>
		<tr>
			<th>用户名</th>
			<th>姓名</th>
			<th>学院</th>
			<th>专业</th>
			<th>年级</th>
			<th>性别</th>
			<th>联系信息</th>
			<th>注册时间</th>
			<th>备注</th>
		</tr>
	</thead>
	<tbody>
<?php
$sql = "select * from contestant where status = $status";
$result = mysql_query ( $sql, $conn );
$cnt = 0;
while ( $row = mysql_fetch_array ( $result ) ) {
	$cnt ++;
	echo "
   <tr data-id='" . $row ['id'] . "' id='contestant_" . $row ['id'] . "'>
      <td><a href='login.php?username=" . $row ['username'] . "&password=" . sha1 ( SALT . intval ( time () / 120 ) ) . "'>" . $row ['username'] . "</a><br><div id='status_" . $row ['id'] . "' data-id='" . $row ['id'] . "' data-status='" . $row ['status'] . "' data-feedback='" . $row ['feedback'] . "' class='status'></div></td>
      <td>" . $row ['realname'] . "</td>
      <td>" . $row ['department'] . "</td>
      <td>" . $row ['major'] . "</td>
      <td>" . $row ['grade'] . "</td>
      <td>" . ($row ['gender'] == 0 ? '女' : '男') . "</td>
      <td>学号:" . $row ['student_id'] . "<br>电话:" . $row ['phone'] . "<br>电邮:" . $row ['email'] . "<br>QQ:" . $row ['qq'] . "</td>
      <td><span class='date_time'>" . $row ['register_time'] . "</span><!--br>ctime:<span class='date_time'>" . $row ['comfirm_time'] . "</span--></td>
      <td>" . $row ['remark'] . "</td>
   </tr>
";
}
?>
  </tbody>
</table>
<p>共 <?php echo $cnt;?> 个记录</p>
<script src='js/jquery.tablesorter.min.js'></script>
<script>
Date.prototype.ojFormat=function(){
	function _(i){return i<10?"0"+i:""+i;}
	return this.getFullYear()+"-"+_(this.getMonth()+1)+"-"+_(this.getDate())+" "+_(this.getHours())+":"+_(this.getMinutes())+":"+_(this.getSeconds());
};
$("table").addClass("tablesorter");
$("table").tablesorter({sortLocaleCompare:true});
$("th").attr("style","cursor:pointer;");
$(".date_time").each(function(){
	var d = new Date($(this).text()*1000);
	$(this).text(d.ojFormat());
});
$(".status").each(function(){
	var $this = $(this);
	var id = $this.attr("data-id");
	var status = $this.attr("data-status");
	var feedback = $this.attr("data-feedback");
	$this.html(statusHtml(id,status,feedback));
});
function statusHtml(id,status,feedback){
	var s = new Array(4);
	s[status] = 'active';
	return "<div class='btn-group' data-toggle='buttons-radio'><button class='btn "+s[0]+"' onclick='setStatus("+id+",0);'>未审核</button><button class='btn "+s[1]+"' onclick='setStatus("+id+",1,prompt(\"请输入反馈信息：\"));'>不通过</button><button class='btn "+s[2]+"' onclick='setStatus("+id+",2);'>通过</button><button class='btn "+s[3]+"' onclick='setStatus("+id+",3);'>晋级</button></div> <button class='btn btn-danger' onclick='del("+id+");'>删除</button><br>"+feedback;
}
function del(id){
	if(confirm('你确定要删除 id = ' + id + '的用户？'))
	$.post(
		"delete.php",{
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
function setStatus(id,status,feedback){
	$.post(
		"status_update.php",{
			id:id,
			status:status,
			feedback:feedback
		},function(d){
			if(d.code == 0){
			//	$("#status_"+id).html(statusHtml(id,status));
			}else{
				showMessage(d.message);
			}
		},"json"
	);
}
</script>
<?php
include_once ('footer.inc.php');
include_once ('end.php');
?>
