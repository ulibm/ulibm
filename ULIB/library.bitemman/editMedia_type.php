<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
            $sql="select * from media_mid where id='$ID'";
            $result=tmq( $sql);
            $Num=tmq_num_rows($result);
            if ($Num == 0)
                {
                echo "<font s><br>No Media_MID $ID</font>";
                exit;
                }
                $row=tmq_fetch_array($result);
                $name=$row["name"];
                $id=$row["id"];
        ?>
<CENTER>
                    <form method = "post" action = "editMedia_typeAction.php" name = "webForm">
                        <table width = "780" align=center border = "0" bgcolor = e3e3e3>
                            <tr>
                                <td align = "right" width = "50%">
                                    <b><font color = "#FF0000">*</font></b> <?php  echo getlang("สถานะ::l::Status"); ?> :
                                </td>
                                <td width = "50%">
<SELECT NAME="status">
<option value="">ปกติ<?php 
$s=tmq("select * from media_mid_status order by name");
while ($r=tmq_fetch_array($s)) {
	$sl="";
	if ($r[code]==$row[status]) {
		$sl="selected";
	}
	echo "<option value='$r[code]' $sl>".getlang($r[name])." ($r[code]) ";
}
?>
			</SELECT>       
			</td>
                            </tr>
                            <tr>
                                <td align = "right" width = "50%">
                                    <b><font color = "#FF0000">*</font></b> <?php  echo getlang("วัสดุของห้องสมุด::l::Library campus"); ?> :
                                </td>
                                <td width = "50%">
<?php 
	frm_libsite("siteoflib",$row[libsite]);
?>
			</td>
                            </tr>
                            <tr>
                                <td align = "right" width = "50%">
                                    <b><font color = "#FF0000">*</font></b> <?php  echo getlang("สถานที่จัดเก็บ::l::Shelf"); ?> :
                                </td>
                                <td width = "50%">
<?php 
frm_itemplace("itemplace",$row[place]);
?>			</td>
                            </tr>
							
							</table>
                        <input type = "submit" name = "Submit" value = "<?php  echo getlang("ตกลง::l::Submit"); ?>">
						<input type = "reset" name = "Submit2" value = "<?php  echo getlang("ยกเลิก::l::Reset"); ?>"><input type = "hidden" name = "mid" value = "<?php  echo "$ID"; ?>"> <A HREF = "media_type.php"><B>Back</B></A>
                    </form>
                    <br>
</CENTER>
<?php 
						foot();	
						?>