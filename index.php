<?php
$title = "东北师范大学 ".date("Y",time())." 年 ACM 校赛";
include_once('header.inc.php');?>
      <form class="form-signin" action="login.php" method="post">
        <h2 class="form-signin-heading">登录</h2>
        <input name="username" type="text" class="input-block-level" placeholder="Username">
        <input name="password" type="password" class="input-block-level" placeholder="Password">
        <button class="btn btn-large btn-primary" type="submit">提交</button>
        <a class="btn btn-large btn-success" href="register.php">注册</a>
      </form>
<script>
$("form").submit(function(){
	var I = this;
	if(this.username.value == "" || this.password.value == ""){
		showMessage("你有空缺的表单项目没有完成！");
	}else{
		$.post(I.action,{
			username:I.username.value,
			password:I.password.value
		},function(d){
			if(d.code==0){
				window.location = "register.php";
			}else{
				showMessage(d.message);
			}
		},"json");
	}
	return false;
});

</script>
<?php
if(isset($_GET['message'])){
	echo "<script>$(function(){showMessage('" . $_GET['message'] . "');});</script>";
} 

include_once('footer.inc.php');