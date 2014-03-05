<?php
session_start();
if($_SESSION['admin']=='admin'){
?>
<p><?php foreach($status_description as $s => $d){
	echo "[<a href='manager.php?status=$s'>$d</a>] ";
} ?> 
[<a href="log_list_all.php">系统日志</a>]
[<a href="list.php">参赛列表</a>]
[<a href="get_seat.php" onclick="return confirm('随机派位将覆盖当前结果！确定么？');">随机派位</a>]
[<a href="clear_seat.php" onclick="return confirm('你将清空当前结果！确定么？');">清空派位</a>]
</p>
<?php }?>
