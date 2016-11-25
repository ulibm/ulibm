<?php 
        include ("../inc/config.inc.php");
		html_start();
		include("_REQPERM.php");
        $tmp=mn_lib();
		//pagesection($tmp);
?><BR><?php 
?><form method="post" action="chk.php" target=dsp>
	<TABLE width="<?php  echo $_TBWIDTH;?>" align=center>
<TR valign=top>
	<TD align=center><?php  echo getlang("คีย์หรือสแกนบาร์โค้ดทรัพยากร (สามารถคั่นหลายรายการด้วยเครื่องหมายคอมม่า)::l::Key or scan item's barcode (or multiple at a time using commas)");?><br><input type="text" name="bcs" ID=bcs style="width: 75%;"> <input type="submit" value=Submit></TD>
</TR>
<script type="text/javascript">
<!--
	tmp=getobj("bcs");
	tmp.focus();
//-->
</script><TR valign=top>
	<TD><iframe name="dsp" width="<?php  echo $_TBWIDTH;?>" height=1000 ID=ifsdp src="chk.php"></iframe></TD>
</TR>
</TABLE>
</form>
<script type="text/javascript">
<!--
	function local_clearform() {
		tmp=getobj("bcs");
		tmp.value="";
		tmp.focus();
	}
//-->
</script>
<?php 
foot();
?>