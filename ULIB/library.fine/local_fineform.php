<?php 

?><TABLE width=780 align=center><FORM METHOD=POST ACTION="<?php  echo $SCRIPT_NAME?>">
<TR>
	<TD align=center><?php  echo getlang("กำหนดการแสดง ในวัน::l::View by date"); ?>
<select name=Fdat><option value="">ไม่ระบุ
<?php 
for ($i = 1; $i <= 31; $i++) {
	echo  "<option value='$i' $sl>$i ";
}
  
?></select>
<?php  echo getlang("เดือน::l::Month"); ?>
<select name=Fmon><option value="">ไม่ระบุ
<?php 
for ($i = 1; $i <= 12; $i++) {
  print "<option value='$i' $sl> ";
  echo $thaimonstr[$i];
}
  
?></select> <?php  echo getlang("ปี::l::Year"); ?>  
<select name=Fyea>
<option value="">ไม่ระบุ
<?php 
 for ($i=$_MSTARTY; $i <= $_MENDY; $i++) {
 print "<option value='$i' $sl>$i";
}
?></select>
<input type="submit" name="Submit"
value="<?php  echo getlang("ตกลง::l::Submit"); ?>">  <BR>
				<A class=a_btn HREF="<?php  echo $SCRIPT_NAME?>?Fdat=<?php  echo date("j");?>&Fmon=<?php  echo date("n");?>&Fyea=<?php  echo (date("Y")+543)?>"><?php  echo getlang("แสดงค่าปรับของวันนี้::l::Fines for today"); ?></A> </font></TD>
</TR>
</FORM>
</TABLE><?php 
if ($Fyea=="") {
	$Fyea=date("Y")+543;
}
echo "<B><CENTER>".getlang("แสดงรายการ::l::DIsplaying")." ";
if ($Fdat=="") {
	echo "".getlang("ทุกวัน::l::all date")." ";
} else {
	echo "".getlang("วันที่::l::date")."  $Fdat";
}

if ($Fmon=="") {
	echo " ".getlang("ทุกเดือน::l::all month")." ";
} else {
	echo " ".getlang("เดือน::l::month")." " .$thaimonstr[$Fmon];
}
echo " ".getlang("ปี::l::Year")." $Fyea</CENTER></B><BR>";
?>