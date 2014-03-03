<?php
define('DB_HOST','127.0.0.1');
define('DB_USER','ccr');
define('DB_PASS','ptKshGBxw5v9VASL');
define('DB_NAME','ccr');
define('SALT','nenuacm-2013');
$conn = mysql_connect(DB_HOST,DB_USER,DB_PASS);
if(!$conn)die('DB WTF?');
mysql_select_db(DB_NAME);


