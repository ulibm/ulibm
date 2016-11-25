<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        mn_lib();

?><BR><BR><TABLE width=500 align=center>
<FORM METHOD=POST ACTION="searching.php">
<TR>
	<TD align=center><B><?php  echo getlang("กรุณาเลือกชุดการนับ::l::Please choose counting set"); ?></B></TD>
</TR>

<?php 
$data=tmq_dump("countuse_name","countuse","name");
$y=floor(getval("_SETTING","countusenumfield"));
for ($i=1;$i<=$y;$i++) {
?>
<TR>
	<TD>
	<?php 
	$fid="countuse".str_fixw($i,2);
$id=trim($data[$fid]);
	if ($id=="")  {
		$name="[".getlang("ยังไม่ได้ตั้งชื่อ::l::Name not set")."]";
	} else {
		$name=$id;
	}

?><IMG SRC="../neoimg/Book.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle>
<A class=a_btn HREF="man.php?countuse=<?php  echo $fid?>"><?php  echo $name?></A>
&nbsp;&nbsp;[<?php 
echo tmq_num_rows(tmq("select id from media_mid where $fid='YES'"));	
?>]

<BR>

	</TD>
</TR>
<?php 
}	
?>
</TABLE><BR><BR><BR>

<?php 
foot();
?> 