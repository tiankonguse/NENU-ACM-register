<?php
session_start ();
$username = $_SESSION ['ACMContestRegistUsername'];
if ($username != "") {
	header ( "Location:profile.php" );
	return;
}
$title = "东北师范大学 " . date ( "Y", time () ) . " 年 ACM 校赛";
include_once ('header.inc.php');
?>
<form class="center-box" action="login.php" method="post">
	<h2 class="center-box-heading">登录</h2>
	<input name="username" type="text" class="input-block-level"
		placeholder="Username"> <input name="password" type="password"
		class="input-block-level" placeholder="Password">
	<p>
		<button class="btn btn-large btn-primary" type="submit">提交</button>
		<a class="btn btn-large btn-success" href="register.php">注册</a>
	</p>
<?php include('news.inc.php'); ?>
      </form>
<script>
$("form").submit(function(){
	var I = this;
	if(this.username.value == "" || this.password.value == ""){
		showMessage("你有空缺的表单项目没有完成！");
	}else{
		$.get(I.action,{
			username:I.username.value,
			password:I.password.value
		},function(d){
			if(d.code==0){
				window.location = ".";
			}else{
				showMessage(d.message);
			}
		},"json");
	}
	return false;
});

</script>
<?php
if (isset ( $_GET ['message'] )) {
	echo "<script>$(function(){showMessage('" . $_GET ['message'] . "');});</script>";
}

include_once ('footer.inc.php');
