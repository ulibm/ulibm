<?php // พ
		header("Content-Type: text/css");
        include ("../inc/config.inc.php");
		$tmp= file_get_contents("./ulib5.css");
		$tmp=str_replace('$dcrURL',$dcrURL,$tmp);
		echo $tmp;
?>