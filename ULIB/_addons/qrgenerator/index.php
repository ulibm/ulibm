<?php 
include("../../inc/config.inc.php");
include("info.php");
head();
include("../chkpermission.php");
include("../menu.php");
$now=time(); 
$input=trim($input);
pagesection(getlang("QR Generator"));
//int
?><center><form method="post" action="index.php">
	<table align=center width=<?php  echo $_TBWIDTH?>>
	<tr>
		<td colspan=2 align=center ><?php  echo getlang("ใส่ข้อความ/URL ที่นี่::l::Enter Text/URL here");?> &nbsp;<input type="text" name="input" value="<?php  echo $input;?>" size=70><input type="submit" value=" OK " ></td>
	</tr>
	<tr>
		<td colspan=2 align=center>
		<?php 
		if ($input!="") {
		?><TABLE width=100% height=100%>
<TR>
	<TD align=center valign=middle><img src="<?php  echo $dcrURL?>inc/phpqrcode/index.php?data=<?php  echo urldecode($input)."&level=M&size=10&"?>" width=400><BR><?php  echo urldecode($input)?></TD>
</TR>
</TABLE>
<?php 
}?>
&nbsp;&nbsp;
</td>
	</tr>
	</table>
</form>
</center><?php 
foot();
?>