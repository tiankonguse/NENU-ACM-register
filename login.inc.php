<?php
function check_login($username){
	global $_SERVER;
	$timestamp = time();
	$ip = mysql_real_escape_string(get_ip());
	$ip_date = $ip.date("m.d.y");
	$remark = $_SERVER['HTTP_USER_AGENT'].' '.$_SERVER['HTTP_REFERER']; 
	$ret = true;
	$res = mysql_query("select * from login_log where username = '$username' and ip_date ='$ip_date'");	
	if(mysql_num_rows($res)){
		$ret = false;
	}
	mysql_query("insert into login_log(username,ip,timestamp,ip_date,remark) values('$username','$ip',$timestamp,'$ip_date','$remark')");	
	return $ret;
}


function get_ip() {
	global $_SERVER;
	$ip = "";
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip .= $_SERVER['HTTP_X_FORWARDED_FOR'].";";
	} elseif ( isset($_SERVER['REMOTE_ADDR'])){
		$ip .= $_SERVER['REMOTE_ADDR'].";";
	}
	return $ip;
}
