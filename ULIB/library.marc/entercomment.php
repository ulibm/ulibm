<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
?><FORM METHOD=POST ACTION="marc.php">

<HR width=780><CENTER><B><?php echo $filex;?></B><BR><BR><?php  echo getlang("คุณสามารถเพิ่ม comment การนำเข้าได้ที่นี่ ::l::You can add import comment here"); ?> 
	<INPUT TYPE=text NAME=addimportid maxlength=30 value='<?php echo $filex;?>'> <FONT class=smaller>(<?php  echo getlang("ไม่ต้องกรอกก็ได้::l::Optional"); ?>)</FONT><BR><BR>
<?php  echo getlang("ระบุคอลเล็กชั่น ::l::Set collection "); ?> <BR>
<?php 

$s=tmq("select * from collections order by name");
$i=0;
$all=tmq_num_rows($s);
while ($r=tmq_fetch_array($s)) {
	$i++;
?><label><?php 
	echo "<img src='$dcrURL/neoimg/collectionicon/$r[icon]' width=24 height=24 align=absbottom>";

?><INPUT TYPE="checkbox" NAME="collist[<?php echo $r[id]?>]" value="<?php echo $r[classid]?>" style="border-width: 0;">
	<B style='font-size: 14px; ' ><?php  echo getlang($r[name])?></B>  </label> &nbsp; 
<?php 
	if ($i<$all) {
		echo "<B>:</B> &nbsp;&nbsp;";
	}
}	?>

<BR><BR>
	<INPUT TYPE="hidden" name=filex value="<?php  echo $filex?>">

<INPUT TYPE=submit value="<?php  echo getlang("กรุณาคลิกที่นี่เพื่อดำเนินการขั้นต่อไป::l:: Click here to continue "); ?>" style='background-color: #EDE0E0'>
</CENTER><HR width=780>
<TABLE cellpadding=2 cellspacing=0 border=0 width=780 align=center>
<TR>
	<TD align=center><A HREF="javascript:void(null);" onclick="tmp=getobj('SETBibID'); tmp.style.display='inline'" style="font-size:13; color:black; text-decoration:none;"><?php  echo getlang("ตั้ง BibID ตามแท็ก::l::Set BibID by tag")?></A>
<div style="display:none;" ID="SETBibID"><B><?php  echo getlang("ตั้ง BibID ตามแท็กใด::l::Set BibID by tag")?>:</B><?php 

?><INPUT TYPE="text" NAME="setbibidcmd" value="<?php echo barcodeval_get("lastsetbibidbytag");?>" >
	<font class=smaller><?php  echo getlang("ปกติเป็นค่าว่าง::l::left empty isdefault value")?></font></label> 
</div></TD>
</TR>
</TABLE>
</FORM>

<?php 
foot();
?>