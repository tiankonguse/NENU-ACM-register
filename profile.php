<?php
session_start ();
$username = $_SESSION ['ACMContestRegistUsername'];
if ($username == "") {
	header ( 'Location:.' );
	return;
}
$title = "东北师范大学 " . date ( "Y", time () ) . " 年 ACM 校赛注册";
include_once ('init.php');
include_once ('header.inc.php');
$result = mysql_query ( "SELECT * FROM contestant WHERE username = '$username'" );
$row = mysql_fetch_assoc ( $result );
$status = $row ['status'];
$nickname = $row ['realname'];
$timestamp = time () * 1000;
?>
<div class="center-box">
	<h2 class="center-box-heading"><?php echo $nickname; ?><small>，欢迎您！</small>
	</h2>
	<p>
		<a class="btn btn-full btn-large btn-success" href="#"
			id="login_contest">登陆比赛</a>
	</p>
	<p>
		<a class="btn btn-full btn-large btn-primary" href="register.php">个人信息
			<small>[<?php echo $status_description[$status];?>]</small>
		</a>
	</p>
	<p>
		<a class="btn btn-full btn-large" href="logout.php">退出登录</a>
	</p>
<?php include('news.inc.php'); ?>
</div>
<script>
$("#login_contest").click(function(){
	$.get("contest.php",{},function(d){
		if(/.*elcome.*/.test(d)){
			window.location="/judge/contest/toListContest.action";
		}else{
			showMessage(d);
		}
	});
});
</script>
<?php
include_once ('footer.inc.php');

include_once ('end.php');