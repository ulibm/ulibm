<?php 
include("../inc/config.inc.php");
include("_REQPERM.php");
head();
$tmp=mn_lib();
pagesection($tmp);
?><table width=<?php  echo $_TBWIDTH?> cellpadding=0 cellspacing=0 border=0 align=center>
<tr>
	<td align=center>
	<a href="forgot.php" target=main class=a_btn><?php  echo getlang("ลืมบัตร/บัตรล่วงหน้า::l::Forgot card/pre-regist"); ?></a>  
	<a href="temp.php" target=main class=a_btn><?php  echo getlang("สมาชิกชั่วคราว/บุคคลภายนอก::l::Tempolary card/Visitor"); ?></a>  
	
	</td>
</tr>
<tr>
	<td><script language="javascript"> 
function local_autosizeiframe(id) { 
	try { 
		frame = getobj(id); 
		frame.scrolling = "no"; 
		frame.scrolling = "no"; 
		innerDoc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document; 
		objToResize = (frame.style) ? frame.style : frame; 
		 tmpfrheight = innerDoc.body.scrollHeight;// + 2; 
		 if (tmpfrheight>1600) {
			// tmpfrheight=1600;
		 }
		 objToResize.height = tmpfrheight;
	} catch (e) { 
		window.status = e.message; 
	} 
} 
</script> 
<iframe width=<?php  echo $_TBWIDTH?> frameborder=no ID=main name=main onload="local_autosizeiframe('main')"></iframe></td>
</tr>
</table>
<script type="text/javascript">
<!--
	setInterval("local_autosizeiframe('main')",500);

//-->
</script>

<?php 
	foot();
?>