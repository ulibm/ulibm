<?php 
function local_gen404() {
header("HTTP/1.0 404 Not Found");
die;
}

if ($_ISULIBHAVESTER!="yes") {
	 local_gen404();
}

function local_genbackbtn($url) {
				 
				?><table align=center>
<tr><td><?php 
				 	html_guidebtn(getlang("<b>Back</b>").",$url".",green,_top");
					?></td></tr>
</table><?php 
}// พ 
?>