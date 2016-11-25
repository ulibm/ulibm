<?php // พ
function localloadmember($memberid,$skipworinkframe="no",$firsttime="no",$alertfine="yes") {
	global $useradminid;
?><SCRIPT LANGUAGE="JavaScript">
<!--
	parent.getobj('display').src="display.viewmember.php?memberid=<?php  echo $memberid?>&firsttime=<?php  echo $firsttime?>&alertfine=<?php  echo $alertfine?>";
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