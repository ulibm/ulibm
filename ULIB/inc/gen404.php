<?php // พ
function gen404() {
	global $_SERVER;
	if (!headers_sent()) {
		//http_response_code(404);
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
		header("HTTP/1.0 404 Not Found");
		exit;
	} else {
		?><!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL <?php  echo $_SERVER[REQUEST_URI]?> was not found on this server.</p>
<hr>
</body></html>

<?php 
		die;
	}
}
?>