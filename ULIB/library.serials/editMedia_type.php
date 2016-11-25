<?php 
;
     include("../inc/config.inc.php"); 
	include("_REQPERM.php");
	if ($framemode=="yes" || $editboxinfo=="yes") {
		html_start();
		loginchk_lib("check");
	} else {
		head();
		mn_lib();
	}
            $sql="select * from media_mid where ID='$IDEDIT'";
            $result=tmq( $sql);
            $Num=tmq_num_rows($result);
            if ($Num == 0)
                {
                echo "<font s><br>No Media_Type ID $IDEDIT</font>";
                exit;
                }
            else
                {
                $row=tmq_fetch_array($result);
								$editing=$row;
								//printr($editing);
                $name=$row["name"];
               // $MID=$row["id"];
        ?>
                    </b></font>
<CENTER>
<form method = "post" action = "editMedia_typeAction.php" name = "webForm">
<INPUT TYPE = "hidden" name = MID value = "<?php  echo $MID;?>">
<INPUT TYPE = "hidden" name = framemode value = "<?php  echo $framemode;?>">
<INPUT TYPE = "hidden" name = calln value = "<?php  echo $calln;?>">
<INPUT TYPE = "hidden" name = editboxinfo value = "<?php  echo $editboxinfo;?>">
<INPUT TYPE = "hidden" name =MIDpage value = "<?php  echo $MIDpage;?>">
<INPUT TYPE = "hidden" name =USESMOD value = "<?php  echo $USESMOD;?>">
<table width = "<?php  echo $_TBWIDTH;?>" align=center border = "0" bgcolor = e3e3e3>
<script>
startrunning=0
</script>
                            <tr>
                                <td align=right>
                                    <?php  echo getlang("ประเภทวัสดุ::l::Material type"); ?></td>
                                <td><?php 
                frm_restype("RESOURCE_TYPE", "$row[RESOURCE_TYPE]");
            ?></td></tr>
							<tr>
                                            <td align=right>
                                                <?php  echo getlang("วัสดุของห้องสมุด::l::At Library campus"); ?></td>
                                            <td><?php 
                                            frm_libsite("FLIBSITE",$row[libsite]);
                                        ?></td></tr>
<tr>
<td align=right>
	<?php  echo getlang("สถานที่จัดเก็บ::l::Shelf"); ?></td>
<td><?php 
//print_r($editing);
frm_itemplace("itemplace",$row[place]);
?>
</td></tr>
                            <tr>
                                <td align = "right" width = "30%">
                                    <b><font color = "#FF0000">*</font></b><?php  echo getlang("เลขทะเบียน::l::Code"); ?>  :
                                </td>
                                <td >
                                    <input type = "text" name = "tabean" size = "50" value = "<?php  echo "$row[tabean]"; 
?>">
                                </td>
                            </tr>
 <tr>
   <td align = "right" >
   <b><font color = "#FF0000">*</font></b> Barcode :
   </td>
  <td >
	  <TABLE cellpadding=0 cellspacing=0 width=100%>
	  <TR valign=top>
	  <?php $jsid="a".randid();?>
		<TD><input type = text name = "bcode" ID="bcode<?php  echo $jsid?>" value = "<?php  echo "$row[bcode]"; ?>"
		 onblur="getobj('bcchecker').src='bccheck.php?bc='+this.value+'<?php echo "&forceskip=".urlencode($row[bcode])?>';"
		 onkeyup="getobj('bcchecker').src='bccheck.php?bc='+this.value+'<?php echo "&forceskip=".urlencode($row[bcode])?>';"
		  onkeydown="return localbckeydown(event,this);"	>
		<?php 
		if ($row[bcode]=="") {
			?>		 		<img border=0 align=absmiddle src="<?php  echo $dcrURL?>neoimg/favbadd16.png" style="cursor: hand; cursor: pointer;" onclick="getobj('bcchecker').src='../library.bitem/getnextbc.php?parentid='+escape('bcode<?php  echo $jsid;?>')+'&randid='+Math.random(); "> <?php 
		}	
		?>
		</TD>
		<TD><?php 
		$_bcjsfunc_skipmulti="yes";
		include("local.bcjsfunc.php");?><iframe src="" width=300 height=25 frameborder=0 SCROLLING=NO ID='bcchecker'></iframe></TD>
	  </TR>
	  </TABLE>
    </td>
   </tr>
 <tr>
   <td align = "right" >
   <b><font color = "#FF0000">*</font></b> Price :
   </td>
  <td >
  <input type = "text" name = "price" size = "50" 
value = "<?php  echo "$row[price]"; 
?>">
    </td>
   </tr>
 <tr>
   <td align = "right" >
   <b><font color = "#FF0000">*</font></b> Note :
   </td>
  <td >
  <input type = "text" name = "note" size = "50" 
value = "<?php  echo "$row[note]"; 
?>">
    </td>
   </tr>  <tr>
   <td align = "right" >
   <b><font color = "#FF0000">*</font></b> Status :
   </td>
  <td >
<SELECT NAME="status">
<?php 
$s=tmq("select * from media_mid_status where 1 order by name");
while ($r=tmq_fetch_array($s)) {
	$sl="";
	if ($r[code]==$row[status]) {
		$sl="selected";
	}
	echo "<option value='$r[code]' $sl>".getlang($r[name]);
   if ($code!='') echo " ($r[code]) ";
}
?>
			</SELECT> 
    </td>
   </tr>  
 <tr>
   <td align = "right" >
 <b><font color = "#FF0000">*</font></b> <?php  echo getlang("ฉบับที่::l::Copy"); ?> :
   </td>
  <td >
 <input type = "text" name = "inumber" size = "50"
value = "<?php  echo "$row[inumber]"; 
?>"> 
 </td> </tr>
<TR valign=top bgcolor=white>
	<TD  class=table_td>enumeration </TD>
	<TD><?php 
		$sr=tmq("select * from serial_info where mid='$MID' ",false);
		$sr=tmq_fetch_array($sr);
		
 echo getlang($sr[enum1]); ?> <INPUT TYPE="<?php if (trim($sr[enum1])!="") { echo "text";}  else {echo "hidden";}?>" NAME="vjenum_1" size=10 value="<?php  echo $boundvar[jenum_1].$editing[jenum_1]?>"> 
		<?php echo getlang($sr[enum2]); 
			if (trim($sr[enum2])!="") {
				
				if ("$sr[enumr2]"=="-1") {
					?> <input type="text" name="vjenum_2" size=5 value="<?php  echo floor($boundvar[jenum_2].$editing[jenum_2]);?>"> <?php 
				} else {
				?>
				<SELECT NAME="vjenum_2"><option><?php 
					$tmpa=explode(',',$sr[enumr2]);
					while (list($sk,$sv)=each($tmpa)) {
						$sl=""; if ($boundvar[jenum_2].$editing[jenum_2]==$sv) {$sl=" selected";}
						echo "<option value='$sv' $sl>$sv";
					}
				?>
				</SELECT>
				<?php }?>
				
			<?php  } else { ?><INPUT TYPE="hidden" NAME="vjenum_2" size=10 value="<?php  echo $boundvar[jenum_2].$editing[jenum_2]?>"><?php }?>
<?php echo getlang($sr[enum3]); 
			if (trim($sr[enum3])!="") {
				if ("$sr[enumr3]"=="-1") {
					?> <input type="text" name="jenum_3" size=5 value="<?php  echo floor($boundvar[jenum_3].$editing[jenum_3]);?>"> <?php 
				} else {
					?>
				<SELECT NAME="jenum_3"><option><?php 
					$tmpa=explode(',',$sr[enumr3]);
					while (list($sk,$sv)=each($tmpa)) {
						$sl=""; if ($boundvar[jenum_3].$editing[jenum_3]==$sv) {$sl=" selected";}
						echo "<option value='$sv' $sl>$sv";
					}
				?>
				</SELECT>
				<?php }
				?> 
			<?php  } else { ?><INPUT TYPE="hidden" NAME="vjenum_3" size=10 value="<?php  echo $boundvar[jenum_3].$editing[jenum_3]?>"><?php }?>
	 <INPUT TYPE="hidden" NAME="vjenum_4" size=10 value="<?php  echo $editing[jenum_4]?>">
	 <INPUT TYPE="hidden" NAME="vjenum_5" size=10 value="<?php  echo $editing[jenum_5]?>">
	 <INPUT TYPE="hidden" NAME="vjenum_6" size=10 value="<?php  echo $editing[jenum_6]?>">
	</TD>
</TR>
<TR valign=top bgcolor=white>
	<TD  class=table_td>chronology </TD>
	<TD>
	<?php 
	 echo getlang("ปี ::l:: Year "); 
	form_quickedit("jchrono_1",$boundvar[jchrono_1].$editing[jchrono_1],"year");
	 echo getlang("เดือน ::l:: Month "); 
	form_quickedit("jchrono_2",$boundvar[jchrono_2].$editing[jchrono_2],"month");
	 echo getlang("วันที่ ::l:: Date "); 
	form_quickedit("jchrono_3",$boundvar[jchrono_3].$editing[jchrono_3],"day");
	?>
 	<INPUT TYPE="hidden" NAME="jchrono_4" size=10 value="<?php  echo   $boundvar[jchrono_4].$editing[jchrono_4]?>"> 
	</TD>
</TR>
<TR valign=top bgcolor=white>
	<TD  class=table_td><B>Bound's Call number</B></TD>
	<TD>
	<TEXTAREA NAME="vcalln" ROWS="3" COLS="50"><?php 
	echo $editing[calln];
?></TEXTAREA>
	</TD>
</TR>
<TR valign=top bgcolor=white>
	<TD  class=table_td>Availability status note</TD>
	<TD>
	<TEXTAREA NAME="javaistatusnote" ROWS="3" COLS="50"><?php  echo $boundvar[javaistatusnote].$editing[javaistatusnote]?></TEXTAREA>
	</TD>
</TR>

<TR valign=top bgcolor=white>
	<TD  class=table_td>Public note </TD>
	<TD>
	<INPUT TYPE="text" NAME="jpublicnote" size=15 id=jpublicnote value="<?php  echo $editing[jpublicnote]?>"> 
	<A HREF="javascript:void(0)" onclick="document.all.jpublicnote.value='' " class=a_btn style='color: black;'><?php  echo getlang("ไม่มีโน๊ต::l::no note");?></A>
	<A HREF="javascript:void(0)" onclick="document.all.jpublicnote.value='Bound' " class=a_btn style='color: darkgreen;'>Bound</A>
	
	</TD>
</TR>
    <tr bgcolor = "#f3f3f3">
      <td width = "27%" valign = "middle">
      <B><font face = "MS Sans Serif" size = "2">Note & status</font></B>
	  </td>
      <td width = "73%">
<input type = text name = "jnonpublicnote" value='<?php  echo $editing[jnonpublicnote]?>' id=jnonpublicnote>
	<A HREF="javascript:void(0)" onclick="document.all.jnonpublicnote.value='' " class=a_btn style='color: black;'><?php  echo getlang("ไม่มีโน๊ต::l::no note");?></A>
	<A HREF="javascript:void(0)" onclick="document.all.jnonpublicnote.value='Expected' " class=a_btn style='color: #6D1D1D;'>Expected</A>
	<A HREF="javascript:void(0)" onclick="document.all.jnonpublicnote.value='Late' " class=a_btn style='color: #660066;'>Late</A>

	</td>
    </tr>	
 
 </table>
 <input type = "submit" name = "Submit" value = "<?php  echo getlang("ตกลง::l::Submit"); ?>">
 <input type = "reset" name = "Submit2" value = "<?php  echo getlang("ยกเลิก::l::Reset"); ?>">
 <input type = "hidden" name = "IDEDIT" value = "<?php  echo "$IDEDIT"; ?>">
	 <input type = "hidden" name = "MID" value = "<?php  echo "$MID"; ?>">
	 	<input type = "hidden" name = "MIDpage" value = "<?php  echo $MIDpage;?>">
<?php 
if ($framemode=="yes") {
 ?>
  <A HREF = "itemlist.php?MID=<?php echo $MID?>&<?php  echo "jenum_1=$jenum_1&jenum_2=$jenum_2&jenum_3=$jenum_3&jenum_4=$jenum_4&jenum_5=$jenum_5&jenum_6=$jenum_6&calln=".urlencode($calln);?>"><B>Back</B></A>
  <?php 
 } elseif ($editboxinfo=="yes") {?>
  <A HREF = "javascript:void(null)" onclick="top.removegb();"><B>Close</B></A>
 <?php 
} else {
	 ?>
  <A HREF = "serial-items.php?MID=<?php echo $MID?>&MIDpage=<?php echo $MIDpage?>"><B>Back</B></A>
<?php 
 }
 ?>
<input type = "hidden" name = "jenum_1" value = "<?php  echo "$jenum_1"; ?>">
<input type = "hidden" name = "jenum_2" value = "<?php  echo "$jenum_2"; ?>">
<input type = "hidden" name = "jenum_3" value = "<?php  echo "$jenum_3"; ?>">
<input type = "hidden" name = "jenum_4" value = "<?php  echo "$jenum_4"; ?>">
<input type = "hidden" name = "jenum_5" value = "<?php  echo "$jenum_5"; ?>">
<input type = "hidden" name = "jenum_6" value = "<?php  echo "$jenum_6"; ?>">

                    </form>
</CENTER>
                    <br>
					<?php 
				}
if ($framemode!="yes" && $editboxinfo!="yes") {
	foot();
}
?>