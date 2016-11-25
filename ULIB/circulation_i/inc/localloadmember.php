<?php // พ
function localloadmember($memberid,$skipworinkframe="no") {
	global $useradminid;
?><SCRIPT LANGUAGE="JavaScript">
<!--
	parent.getobj('display').src="display.viewmember.php?memberid=<?php  echo $memberid?>";
	<?php  
		if ($skipworinkframe=="no") {?>
	parent.getobj('working').src="working.viewmember.php?memberbarcode=<?php  echo $memberid?>";
	<?php 
	}	
	?>
//-->
</SCRIPT><?php 
}
?>