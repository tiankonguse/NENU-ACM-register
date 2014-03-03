<?php
define ( 'DB_HOST', '127.0.0.1' );
define ( 'DB_USER', 'ACMContestRegist' );
define ( 'DB_PASS', 'NTu3q4qWDP3x2GPK' );
define ( 'DB_NAME', 'ACMContestRegister' );
define ( 'SALT', 'nenuacm' );
define ( 'DEBUG', 0 );
define ( 'ERROR', 1 );
define ( 'SUCCESS', 0 );

if (DEBUG != 0) {
	include_once ('debug.php');
}

$conn = mysql_connect ( DB_HOST, DB_USER, DB_PASS );

if (DEBUG != 0) {
	var_dump ( $conn );
}

if (! $conn)
	die ( 'DB WTF?' );
$result = mysql_select_db ( DB_NAME );

if (DEBUG != 0) {
	var_dump($result);
}


