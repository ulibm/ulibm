<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
?><FORM METHOD=POST ACTION="marc.php">

<HR width=780><CENTER><B><?php echo $filex;?></B><BR><BR><?php  echo getlang("คุณสามารถเพิ่ม comment การนำเข้าได้ที่นี่ ::l::You can add import comment here"); ?> 
	<INPUT TYPE=text NAME=addimportid maxlength=30 value='<?php echo $filex;?>'> <FONT class=smaller>(<?php  echo getlang("ไม่ต้องกรอกก็ได้::l::Optional"); ?>)</FONT><BR><BR>

	<INPUT TYPE="hidden" name=filex value="<?php  echo $filex?>">

<INPUT TYPE=submit value="<?php  echo getlang("กรุณาคลิกที่นี่เพื่อดำเนินการขั้นต่อไป::l:: Click here to continue "); ?>" style='background-color: #EDE0E0'>
</CENTER>
</FORM>

<?php 
foot();
?>