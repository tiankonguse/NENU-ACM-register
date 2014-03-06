<?php
session_start ();
$username = $_SESSION ['ACMContestRegistUsername'];
if ($username == "") {
	$title = "东北师范大学 " . date ( "Y", time () ) . " 年ACM/ICPC程序设计竞赛 - 注册";
} else {
	$title = "东北师范大学 " . date ( "Y", time () ) . " 年ACM/ICPC程序设计竞赛 - 信息修改";
}
include_once ('init.php');
include_once ('header.inc.php');

?>
<form class="form-horizontal" action="register_do.php" method="post">
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
				<option value="2009">2009</option>
			</select>
		</div>
	</div>
<?php textField('major','专业'); ?>
<?php textField('student_id','学号'); ?>
  <div class="control-group">
		<label class="control-label" for="gender">性别</label>
		<div class="controls">
			<select id="gender" name="gender">
				<option value="1">男</option>
				<option value="0">女</option>
			</select>
		</div>
	</div>
<?php textField('phone','电话'); ?>
<?php textField('email','电子邮箱'); ?>
<?php textField('qq','QQ号'); ?>
  <div class="control-group">
		<label class="control-label" for="remark">备注</label>
		<div class="controls">
			<textarea name="remark" id="remark" style="height: 100px; width: 50%"
				placeholder="备注信息，请填写一些你想补充的内容，例如你参加过的算法比赛，或者你对自己在程序设计方面的评价。"></textarea>
		</div>
	</div>

	<div class="control-group form-actions">
		<input type="submit" id="submit" name="submit" class="btn btn-primary"
			value="注册">
	</div>
</form>
<script>
<?php echo "var username='$username';"; ?>
if(username != ""){
	loadUserInfo();
	$("#submit")[0].value="修改";
}
$("#submit").after(" <a href='./' class='btn'>返回</a>");

$("#major").attr("placeholder","输入部分专业名，根据提示选");

function loadUserInfo(){
	$("#username").attr("disabled","disabled");
	$.get(
		"profile_data.php",{},function(d){
			if(d.code==0){
				var feedback = d.data.feedback || "";
				$(".alert").remove();
				if(d.data.status == 0){
					$("form").before("<div class='alert alert-info'><i class='icon icon-info-sign icon-white'></i> 您的信息已经提交，请等待审核，在此期间，您可以修改您的信息。</div>");
				}else if(d.data.status == 1){
					$("form").before("<div class='alert alert-error'><i class='icon icon-exclamation-sign icon-white'></i> 您提交的信息已经审核，但是未能通过：<br><b>理由如下："+feedback+"</b><br>请修改成真实有效的信息，如有疑问，请联系我们。</div>");
				}else if(d.data.status == 2){
					$("form").before("<div class='alert alert-success'><i class='icon icon-ok-circle icon-white'></i> 您的信息已经通过审核，现在您不能修改你的信息，如果需要，请联系我们。</div>");
				}else if(d.data.status == 3){
					$("form").before("<div class='alert alert-success'><i class='icon icon-ok-circle icon-white'></i> 您已经晋级最终比赛，现在您不能修改你的信息，如果需要，请联系我们。</div>");
				}
				$("#password").attr("placeholder","新密码，不修改，请留空。");
				$("label[for='password']").text("新密码，留空不改");
				for(var k in d.data){
					if($("#"+k).length == 0) continue;
					$("#"+k)[0].value=d.data[k];
					if(d.data.status >= 2) $("#"+k)[0].disabled='disabled';
				}
			}
		},"json"
	);
}
$("form").submit(function(){
	var $this = $(this);
	var I = this;
	var action = I.action, data = {};
	for(var i = 0; i < this.length; i++){
		if(username != "" && (this[i].name=="remark"||this[i].name=="password"||this[i].name=="password2")){
		}else if(this[i].value==""&&this[i].name!="remark"){
			showMessage("您有空表单项目没填："+this[i].name+"",function(){
				setTimeout(function(){$(I[i]).focus();},1000);
			});
			return false;
		}
		data[this[i].name] = this[i].value;
	}
	if((data.password+"").length < 6 && (username == ""||data.password2 != "")){
		showMessage("密码太短！",function(){
			setTimeout(function(){$("#password").focus();},1000);
		});
		return false;
	}
	if(data.password != data.password2){
		showMessage("两次密码不一致！",function(){
			setTimeout(function(){$("#password2").focus();},1000);
		});
		return false;
	}
	if(username != ""){
		data['username']=username;
	}
	$.post(
		action,
		data,
		function(d){
			if(d.code==0){
			showMessage(d.message,function(){
				if(username != "")
					loadUserInfo();
				else
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

var majorList = ['马克思主义哲学','中国哲学','伦理学','科学技术哲学','武警指挥','政治经济学','国际经济与贸易','世界经济','人口、资源与环境经济','区域经济学','财政学','金融学','劳动经济学','法学','宪法学与行政法学','政治学理论','中外政治制度','科学社会主义与国际共','中共党史','马克思主义理论与思想','国际政治','社会学','教育学原理','课程与教学论','教育史','比较教育学','学前教育学','高等教育学','教育技术学','基础心理学','发展与教育心理学','应用心理学','体育人文社会学','运动人体科学','体育教育训练学','民族传统体育学','文艺学','汉语言文字学','中国古典文献学','中国古代文学','中国现当代文学','比较文学与世界文学','英语语言文学','俄语','日语语言文学','日语','外国语言学及应用语言','新闻学','传播学','音乐','音乐学','美术学','设计艺术学','视觉艺术','广播电视艺术学','艺术设计','服装','史学理论及史学史','考古学及博物馆学','历史地理学','历史文献学','专门史','中国古代史','中国近现代史','世界史','基础数学','概率论与数理统计','应用数学','运筹学与控制论','理论物理','粒子物理与原子核物理','凝聚态物理','无机化学','分析化学','有机化学','物理化学','高分子化学与物理','自然地理学','人文地理学','地图学与地理信息系统','城市与区域规划','湿地科学','植物学','动物学','生理学','微生物学','遗传学','细胞生物学','生物化学与分子生物学','生态学','电路与系统(理学)','计算机软件与理论(理)','计算机应用技术(理学)','环境科学(理学)','环境工程(理学)','材料物理与化学','计算机科学与技术','城市规划与设计','核技术及应用','环境科学','草业科学','教育学类','军事理论教研室','就业指导','女性研究','教育学','公共事业','心理学','小学教育','学前教育','思想政治教育','法学','社会学','行政管理','哲学','社会学','思想政治教育','国际经济与贸易','会计学','市场营销','人力资源管理','经济学','工商管理','金融学','财政学','汉语言文学','编辑出版学','新闻学','广播电视新闻学','历史学','旅游管理','全球文明史','英语系','英语','英语（语言文学）','英语（翻译）','日语系','俄语系','英语(电子商务)','二外教研室','日语(电子商务)','英语（科技交流）','俄语（电子商务）','俄语','日语','舞蹈编导','音乐学','音乐学','美术学(非师范)','美术学','艺术设计','雕塑','美术教育','动画专业','服装设计','图书馆学','广告学1','国际政治','公共写作','大学健康','会计学','企业管理','行政管理','教育经济与管理','土地资源管理','图书馆学','情报学','数学与应用数学','基础数学','统计学','物理学','电子信息科学与技术','电气工程及其自动化','材料物理','应用化学','化学','化学（师范）','化学（普通）','生物科学类','生物技术','基地班','生物科学','生态学','地理科学','资源环境与城乡规划管','环境科学','地理信息系统','体育教育','运动训练','民族传统体育','计算机科学与技术','计算机科学与技术(中美合作)','软件工程','软件工程（计）','教育技术学','广播电视编导','广播电视新闻学','电视摄像','播音与节目主持艺术','图书馆专业','广告学','教育技术学','广播电视编导','广播电视新闻','播音与主持艺术','数学与应用数学类','军体公共课教研室','马列教研室','物理学类','经济学类','综合知识教研室','工商管理类','计算机公共课教研室','地理科学类','公共教育选修','大学外语教研室','大学英语','大学俄语','大学日语','汉语言','公共数学'];
$(function(){$("#major").typeahead({source:majorList});});
</script>


<?php
include_once ('footer.inc.php');
function selectField($name, $displayName, $arr) {
}
function textField($name, $displayName) {
	echo "
  <div class='control-group'>
    <label class='control-label' for='$name'>$displayName</label>
    <div class='controls'>
      <input type='text' id='$name' name='$name'  placeholder='$displayName'>
    </div>
  </div>
";
}
function passField($name, $displayName) {
	echo "
  <div class='control-group'>
    <label class='control-label' for='$name'>$displayName</label>
    <div class='controls'>
      <input type='password' id='$name' name='$name'  placeholder='$displayName'>
    </div>
  </div>
";
}

include_once ('end.php');