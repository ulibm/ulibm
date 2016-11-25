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
             <BR>
                        <table width = "780" align=center border = "0" bgcolor = e3e3e3>

						
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("ติดต่อกับบริษัท::l::Contact company");?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2">
<?php  
$s=tmq("select * from acq_company where id='$row[company]'  ");
$r=tmq_fetch_array($s);
echo "$r[name]";
?>
</font></td>
</tr>

<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("สถานะ::l::Status");?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><?php echo $row[status]?> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("หมายเหตุ::l::Note");?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><?php echo $row[note]?> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td colspan=2>
	<A class=a_btn HREF="mediaman.list.php?edit=<?php echo $ID?>&text=delmenu" target=mediaman><IMG SRC="../neoimg/LIST2.gif" WIDTH="16" HEIGHT="14" BORDER="0" ALT="" align=absmiddle><?php echo getlang("แสดงรายการ::l::Show items");?> </A>
	| <A class=a_btn HREF="mediaman.php?edit=<?php echo $ID?>&text=addmenu" target=mediaman><IMG SRC="../neoimg/plus.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php echo getlang("เพิ่มวัสดุสารสนเทศ::l::Add items");?></A>
	| <A class=a_btn  HREF="mediaman.php?edit=<?php echo $ID?>&text=delmenu" target=mediaman><IMG SRC="../neoimg/minus.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php echo getlang("ลบวัสดุสารสนเทศ::l::Delete items");?></A>
	| <A class=a_btn HREF="media_type.php"><B><?php echo getlang("กลับ::l::Back");?></B></A><BR>
	 <A class=a_btn HREF="_print.php?ID=<?php echo $ID?>" target=_blank><?php echo getlang("พิมพ์ใบสั่งซื้อ::l::Print order");?></A>
	| <A class=a_btn HREF="_printsob.php?ID=<?php echo $ID?>" target=_blank><?php echo getlang("พิมพ์ใบสอบราคา::l::Print request info.");?></A>
	| <A class=a_btn HREF="_printlist.php?ID=<?php echo $ID?>" target=_blank><?php echo getlang("พิมพ์รายการวัสดุฯ::l::Print items");?></A>
	<BR>
		<font face = "MS Sans Serif" size = "2">
		<iframe src="mediaman.list.php?edit=<?php echo $ID?>" name=mediaman width=650 height=400></iframe>
		 </font></td>

</tr></table>


                    <br>
</CENTER>
<?php  
						foot();	
						?>