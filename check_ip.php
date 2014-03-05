<?php

function check($username){
	global $_SERVER;
	$ip = $_SERVER["REMOTE_ADDR"];
	$real_ip = get_real_ip(); 
	$other = " ";
	return write_log($username, $ip, $real_ip, $other);
//	return $ip." ".$real_ip." ".write_log($username, $ip, $real_ip, $other);
}


function write_log($username, $ip, $real_ip, $other){
	global $conn;
	$username = mysql_real_escape_string($username);
	$ip= mysql_real_escape_string($ip);
	$real_ip= mysql_real_escape_string($real_ip);
	$other= mysql_real_escape_string($other);

	if($username == 'admin'){
		return true;	
	}

	$time = time();

	$sql = "insert into login_ip (username,real_ip,ip,other,time) values ('$username','$real_ip','$ip','$other','$time')";
	

	$result = mysql_query($sql ,$conn);
	
//	return $result;

	//$now = getdate();
	//$time = mktime(0,0,0,$now['mon'],$['mday'],$now['year']);

	$time = mktime(0,0,0);
	$sql = "select distinct real_ip from login_ip where username = '$username' and time > $time";

	$result = mysql_query($sql ,$conn);
	if(mysql_num_rows($result) == 1){	
		return true;
	}else{
		return false;	
	}

return true;
}


  
function get_real_ip() {
	global $_SERVER;
	$unknown = 'unknown';
	if ( 
	isset($_SERVER['HTTP_X_FORWARDED_FOR']) 
	&& $_SERVER['HTTP_X_FORWARDED_FOR']
	&& strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown) ) {
      	
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
       
	 } elseif ( 
	isset($_SERVER['REMOTE_ADDR']) 
	&& $_SERVER['REMOTE_ADDR'] 
	&& strcasecmp($_SERVER['REMOTE_ADDR'], $unknown) ) {
      
		$ip = $_SERVER['REMOTE_ADDR'];
	}	
	if (false !== strpos($ip, ',')){
		$ip = reset(explode(',', $ip));
	}
	return $ip;
}

?>

