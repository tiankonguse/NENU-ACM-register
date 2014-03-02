<?php
$username = trim($_SEESION['username']);
if($username == ""){
	header('Location:.');
	return;
}
$title = "东北师范大学 2013 年 ACM 校赛注册";
include_once('init.php');
include_once('header.inc.php');

?>
<form class="form-horizontal" action="register_do.php">
<?php textField('username','用户名'); ?>
<?php passField('password','密码'); ?>
<?php passField('password2','请重复密码'); ?>
<?php textField('realname','真实姓名'); ?>
  <div class="control-group">
    <label class="control-label" for="department">学院</label>
    <div class="controls">
<select id="department" name="department">
<option value="教育学部">教育学部</option>
<option value="政法学院">政法学院</option>
<option value="经济学院">经济学院</option>
<option value="商学院">商学院</option>
<option value="文学院">文学院</option>
<option value="历史文化学院">历史文化学院</option>
<option value="外国语学院">外国语学院</option>
<option value="音乐学院">音乐学院</option>
<option value="美术学院">美术学院</option>
<option value="马克思主义学部">马克思主义学部</option>
<option value="数学与统计学院">数学与统计学院</option>
<option value="计算机科学与信息技术学院" selected="selected">计算机科学与信息技术学院</option>
<option value="软件学院">软件学院</option>
<option value="物理学院">物理学院</option>
<option value="化学学院">化学学院</option>
<option value="生命科学学院">生命科学学院</option>
<option value="地理科学学院">地理科学学院</option>
<option value="环境学院">环境学院</option>
<option value="体育学院">体育学院</option>
<option value="传媒科学学院">传媒科学学院</option>
<option value="远程与继续教育学院">远程与继续教育学院</option>
<option value="民族教育学院">民族教育学院</option>
<option value="留学生教育学院">留学生教育学院</option>
<option value="生物基础实验教学中心">生物基础实验教学中心</option>
<option value="传媒实验教学中心">传媒实验教学中心</option>
<option value="美术实验教学中心">美术实验教学中心</option>
<option value="化学基础教学实验中心">化学基础教学实验中心</option>
<option value="物理基础实验教学中心">物理基础实验教学中心</option>
<option value="经济管理实验教学中心">经济管理实验教学中心</option>
</select>
    </div>
  </div>
  <div class="control-group">
     <label class="control-label" for="grade">年级</label>
     <div class="controls">
        <select id="grade" name="grade">
           <option value="2012">2012</option>
           <option value="2011">2011</option>
           <option value="2010">2010</option>
           <option value="2010">2009</option>
        </select>
     </div>
  </div>
<?php textField('major','专业'); ?>
<?php textField('student_id','学号'); ?>
  <div class="control-group">
     <label class="control-label" for="gender">性别</label>
     <div class="controls">
        <select id="gender" name="gender">
           <option value="true">男</option>
           <option value="false">女</option>
        </select>
     </div>
  </div>
<?php textField('phone','电话'); ?>
<?php textField('email','电子邮箱'); ?>
<?php textField('qq','QQ号'); ?>
  <div class="control-group">
     <label class="control-label" for="remark">备注</label>
     <div class="controls">
	<textarea name="remark" id="remark" style="height:100px;width:50%" placeholder="备注信息，请填写一些你想补充的内容，例如你参加过的算法比赛，或者你对自己在程序设计方面的评价。"></textarea>
     </div>
  </div>

  <div class="control-group form-actions">
      <input type="submit" class="btn btn-primary" value="注册">
  </div>
</form>
<script>

$("form").submit(function(){
	var $this = $(this);
	var action = this.action, data = {};
	for(var i = 0; i < this.length; i++){
		if(this[i].name=="remark")continue;
		if(this[i].value==""){
			$(this[i]).focus();
			return false;
		}
		data[this[i].name] = this[i].value;
	}
	if(data.password != data.password2){
		showMessage("两次密码不一致！",function(){
			setTimeout(function(){$("#password2").focus();},1500);
		});
		return false;
	}
	$.post(
		action,
		data,
		function(d){
			if(d.code==0){
			showMessage(d.message,function(){
				window.location.reload();
			});
			}else{
				showMessage(d.message);
			}
		},
		"json"
	);
	return false;
});

</script>


<?php
include_once('footer.inc.php');
function selectField($name,$displayName,$arr){
	
}



function textField($name,$displayName){
	echo "
  <div class='control-group'>
    <label class='control-label' for='$name'>$displayName</label>
    <div class='controls'>
      <input type='text' id='$name' name='$name'  placeholder='$displayName'>
    </div>
  </div>
";
}

function passField($name,$displayName){
	echo "
  <div class='control-group'>
    <label class='control-label' for='$name'>$displayName</label>
    <div class='controls'>
      <input type='password' id='$name' name='$name'  placeholder='$displayName'>
    </div>
  </div>
";
}





include_once('end.php');
