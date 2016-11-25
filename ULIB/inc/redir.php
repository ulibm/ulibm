<?php // พ
function redir($xxx,$sec=0) {
   ///die("redir($xxx,$sec)");
	if (!headers_sent() && $sec==0) {
		header("Location: $xxx");
		return;
	}
	?>
	<meta http-equiv = "refresh" content = "<?php echo $sec?>;URL=<?php echo $xxx?>">
	<?php 
}
?>