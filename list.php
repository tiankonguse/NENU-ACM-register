<?php
$title = "东北师范大学 2013 年 ACM 校赛注册 - 晋级列表";
include_once('init.php');
include_once('header.inc.php');
include('admin_menu.php');
?>
<table class="table table-striped table-bordered table-condensed tablesorter" style="word-break:break-all;">
<thead>
    <tr>
      <th>No.</th>
      <th>姓名</th>
      <th>学院</th>
      <th>专业</th>
      <th>年级</th>
      <th>学号</th>
      <th>性别</th>
      <th>座位号</th>
    </tr>
  </thead>
  <tbody>
<?php
$sql = "select * from contestant where status = ".CONTEST_STATUS;
$result = mysql_query($sql ,$conn);
$cnt = 1;
while($row=mysql_fetch_array($result)) {
echo "
   <tr data-id='".$row['id']."' id='contestant_".$row['id']."'>
      <td>".($cnt++)."</td>
      <td>".$row['realname']."</td>
      <td>".$row['department']."</td>
      <td>".$row['major']."</td>
      <td>".$row['grade']."</td>
      <td>".$row['student_id']."</td>
      <td>".($row['gender']==0?'女':'男')."</td>
      <td>".$row['seat']."</td>
   </tr>
";
 } ?>
  </tbody>
</table>
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
</script>
<?php
include_once('footer.inc.php');
include_once('end.php');
?>
