<?php 
;
include("../inc/config.inc.php");
head();
$_REQPERM="itemplace";
$tmp=mn_lib();

$sql="select * from media_place where code='$ID'";

$result=tmq( $sql);

$Num=tmq_num_rows($result);

if ($Num == 0)

{

echo "<font s><br>No media_place ID $code</font>";

exit;

}


$row=tmq_fetch_array($result);

$name=$row["name"];

$code=$row["code"];

?>

<CENTER>
	<form method = "post" action = "editMedia_typeAction.php" name = "webForm">

		<table width = "780" border = "0" bgcolor = e3e3e3>

<tr>
<td  align=right>
<?php  echo getlang("สาขาห้องสมุด::l::Library campus"); ?><br> </font></td>
<td>
<font face = "MS Sans Serif" size = "2"> <B><?php  echo get_libsite_name($row[main])?></B> </font></td>
</tr>

			<tr>

				<td align = "right" width = "50%">

					<b><font color = "#FF0000">*</font></b> <?php  echo getlang("อักษรย่อ::l::Code"); ?> :

				</td>

				<td width = "50%">

<?php 
if ($row[delable]=="YES") {
?>
<input type = "text" name = "code" size = "10" value = "<?php  echo "$code"; ?>">
<?php 
} else {
?><input type = "hidden" name = "code" size = "10" value = "<?php  echo "$code";?>"><B><?php  echo "$code";?></B><?php 
}?>
				</td>

			</tr>

			<tr>
				<td align = "right" width = "50%">
					<b><font color = "#FF0000">*</font></b> <?php  echo getlang("เลขเรียกประจำคอลเลกชั่น::l::Callnumber for collection"); ?> :
				</td>
				<td width = "50%">
<input type = "text" name = "collcode" size = "10" value = "<?php  echo "$row[collcode]"; ?>">
				</td>
			</tr>
			<tr>
				<td align = "right" width = "50%">
					<b><font color = "#FF0000">*</font></b> <?php  echo getlang("ชื่อเต็ม::l::Name"); ?> :
				</td>
				<td width = "50%">
					<input type = "text" name = "name" size = "50" value = "<?php  echo "$name"; ?>">
				</td>
			</tr>
			<tr>
				<td align = "right" width = "50%">
					<b><font color = "#FF0000">*</font></b> <?php  echo getlang("อนุญาตขอยืม::l::Allow request"); ?> :
				</td>
				<td width = "50%">
<?php  form_quickedit("isrq",$row[isrq],"yesno");?>				</td>
			</tr>
			<!-- <tr>
				<td align = "right" width = "50%">
					<b><font color = "#FF0000">*</font></b> <?php  echo getlang("เป็นสถานที่หลักของทรัพยากร::l::Default location for"); ?> :
				</td>
				<td width = "50%">
<?php  frm_restype("defformattype",$row[defformattype],"YES");?>				</td>
			</tr> -->
		</table>

		<input type = "submit" name = "Submit" value = "<?php  echo getlang("ตกลง::l::Submit"); ?>">
		<input type = "reset" name = "Submit2" value = "<?php  echo getlang("ยกเลิก::l::Reset"); ?>">
		<input type = "hidden" name = "mid" value = "<?php  echo "$ID"; ?>">

<A HREF="media_type.php"><?php  echo getlang("กลับ::l::Back"); ?></A> 
	</form>

	<br>
</CENTER>

<?php 

foot();
?>