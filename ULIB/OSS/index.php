<?php 
include("../inc/config.inc.php");
if ($logout=="true") {
sessionval_set("ossmemid","");
}
head();
html_start();
include("localhead.php");
//pagesection(getlang("บริการ One Stop Service::l::One Stop Service"));

$tbname="library_site";

?>
<table width="<?php  echo $_TBWIDTH;?>" align=center border=0>
<tr valign=middle>

<td width=240 >&nbsp;</td>

	<td align=center>
	<a href="<?php 
	if ($_memid!="") {
		 echo "new.php";
	} else {
		echo "newuser.php";
	}
	?>" class=myButton><?php  echo getlang("ส่งคำขอใหม่::l::New Request");?></a>
	<a href="<?php 
	if ($_memid!="") {
		 echo "myrequest.php";
	} else {
		echo "newuser.php";
	}
	?>" class=myButton><?php  echo getlang("ตรวจสอบสถานะ::l::Check Status"); //ตรวจสอบคำขอ::l::?></a>
	<?php 	if ($_memid=="") {?>
		<a href="newuser.php" class=myButton><?php  echo getlang("ล็อกอิน::l::Login"); //ตรวจสอบคำขอ::l::?></a>
	<?php }?>


<br>
<br>
	<!--  -->
	


<form method="post" action="" style="margin: 0px 0px 0px 0px; padding:  0px 0px 0px 0px;">Search your request<!-- ค้นหาด้วยชื่อเรื่อง / ชื่อผู้แต่ง  --> &nbsp;<input type="text" name="quicksearch" onkeyup="quicksearchfunc(this);" >	<script type="text/javascript">
<!--
	function quicksearchfunc(wh) {
		tmp=getobj("dsplist");
		tmp.src="index.dsplist.php?kw="+wh.value
	}
//-->
</script></form>
	<!--  -->
	</td>
<td width=240 align=center>&nbsp;<br>

</tr>
</table>
<?php //pagesection(getlang("History")); ?>
	<table width="<?php  echo $_TBWIDTH;?>" align=center><tr>
	<td align=center>
	<iframe width=<?php  echo $_TBWIDTH;?> src="index.dsplist.php" height=1500 frameborder=NO ID=dsplist style="align: bottom"></iframe>
	</td>
</tr>
</table>
</center>
<?php 

foot();
?>