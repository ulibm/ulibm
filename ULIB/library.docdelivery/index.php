<?php 
include("../inc/config.inc.php");
head();// พ
include("_REQPERM.php");
$tmp=mn_lib();
//pagesection($tmp);
?>
<table cellpadding=0 cellspacing=0 border=0 align=center width="<?php  echo $_TBWIDTH?>">
<tr valign=top>
	<td width=200>
	
	<?php  
	include("menu.php");?>
	
	</td>
	<td width="<?php  echo $_TBWIDTH-200?>">
<script language="javascript"> 
function resizeIframemain(id) { 
	try { 
		frame = document.getElementById(id); 
		frame.scrolling = "no"; 
		innerDoc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document; 
		objToResize = (frame.style) ? frame.style : frame; 
		 tmpfrheight = innerDoc.body.scrollHeight + 2; 
		 if (tmpfrheight>5500) {
			 tmpfrheight=5500;
		 }
		 if (tmpfrheight<700) {
			 tmpfrheight=700;
		 }
		 objToResize.height = tmpfrheight+50;
	} catch (e) { 
		window.status = e.message; 
	} 
} 
</script> 
	<iframe src="./inbox.php" width="<?php  echo $_TBWIDTH-200?>" height=550 FRAMEBORDER="yes" BORDER=0 SCROLLING=yes
	 id="mainframe" name="mainframe" onload="resizeIframemain('mainframe');" ></iframe></td>
</tr>
</table>
<?php 
foot();
?>