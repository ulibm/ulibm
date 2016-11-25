<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
            $sql="select * from acq_acq where id='$ID'";

            $result=tmq( $sql);

            $Num=tmq_num_rows($result);

            if ($Num == 0)

                {

                echo "<font s><br>No Media_Type ID $ID</font>";

                exit;

                }


                $row=tmq_fetch_array($result);

                $name=$row["name"];

                $id=$row["id"];

        ?>
<CENTER>
                    <form method = "post" action = "editMedia_typeAction.php" name = "webForm">

             
                        <table width = "780" align=center border = "0" bgcolor = e3e3e3>

						
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php  echo getlang("ติดต่อกับบริษัท::l::Contact company");?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2">
<select name = company>
<?php 
$s=tmq("select * from acq_company order by  name ");
while ($r=tmq_fetch_array($s)) {
	$sl="";
	if ($r[id]==$row[company]) {
		$sl="selected";
	}
	echo "<option value='$r[id]' $sl>$r[name]";
}
?></select>
</font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php  echo getlang("สถานะ::l::Status");?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2">
<select name = status>
<?php 
$s=tmq("select * from acq_acq_status order by  ordr ");
while ($r=tmq_fetch_array($s)) {
	$sl="";
	if ($r[status]==$row[status]) {
		$sl="selected";
	}
	echo "<option value='$r[status]' $sl>$r[status]";
}
?></select>
</font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php  echo getlang("หมายเหตุ::l::Note");?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "note" value="<?php  echo $row[note]?>"> </font></td>
</tr>
</table>

                        <input type = "submit" name = "Submit" value = "<?php  echo getlang("ตกลง::l::Submit");?>">
						<input type = "reset" name = "Submit2" value = "<?php  echo getlang("ยกเลิก::l::Clear");?>"><input type = "hidden" name = "mid" value = "<?php  echo "$ID"; ?>"> <A HREF = "media_type.php"><B>Back</B></A>

                    </form>

                    <br>
</CENTER>
<?php 
						foot();	
						?>