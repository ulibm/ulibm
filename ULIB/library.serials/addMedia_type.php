<?php  
     include("../inc/config.inc.php"); 
	head();
	include("_REQPERM.php");
	mn_lib();
	?>   <form name = "form1" method = "post" action = "addMedia_typeAction.php" ><?php  
	
	if ($mode=="bounditem") {
	//print_r($slist);
	$sumprice=0;
?>
<?php pagesection( getlang("เย็บเล่มวารสาร::l::items bounding")); ?>
<TABLE width=<?php echo $_TBWIDTH;?> align=center class=table_border>

<TR class=table_head>
	<TD><?php echo getlang("บาร์โค้ด::l::Barcode"); ?></TD>
	<TD><?php echo getlang("เลขทะเบียน::l::Code"); ?></TD>
	<TD><?php echo getlang("ข้อมูล::l::Information"); ?></TD>
</TR>
<?php  
$boundvar=Array();
$boundvar[jpublicnote]="Bound";
$selectallsql="0  ";
foreach ($slist as $value) {
	$selectallsql.=" or id='$value'  ";
	$s=tmq("select * from media_mid where id='$value' ");
	$s=tmq_fetch_array($s);
	
	$boundvar[javaistatusnote].=",".serial_get_volstr($value);
   $sumprice=$sumprice+$s[price];
	?><INPUT TYPE="hidden" name='slist[]' value="<?php echo $value?>"><TR class=table_td>
	<TD><?php echo $s[bcode];?></TD>
	<TD><?php echo $s[tabean];?></TD>
	<TD><?php  echo "".serial_get_volstr($value);?></TD>
</TR><?php  
}

$boundvar[javaistatusnote]=trim($boundvar[javaistatusnote],',');
	//printr($boundvar);
	$allsql=tmq("select * from media_mid where $selectallsql order by jchrono_1 , jchrono_2 , jchrono_3 ,jenum_1 ,jenum_2 ,jenum_3,jenum_4,jenum_5,jenum_6 ",false);
	$tmpi=0;
	$tmpalli=tmq_num_rows($allsql);
	while ($allsqlr=tmq_fetch_array($allsql)) {
		$tmpi++;
		if ($tmpi==1) {
			$firstcalln=serial_get_volstr($allsqlr[id]);
		}
		if ($tmpi==$tmpalli) {
			$lastcalln=serial_get_volstr($allsqlr[id]);
			$boundvar[jchrono_1]=$allsqlr[jchrono_1];
			$boundvar[jchrono_2]=$allsqlr[jchrono_2];
			$boundvar[jchrono_3]=$allsqlr[jchrono_3];
		}
	}
?>

</TABLE><br />

<?php  
	 } 
	 ?>
                    <table width = "<?php echo $_TBWIDTH;?>" align=center border = "0" cellspacing = "0" cellpadding = "0">

                        <tr valign = "top">

                            <td>
                                <div align = "center">

                                    <font face = "MS Sans Serif, Microsoft Sans Serif" size = "3"> </font>

                                </div>

                             

                <INPUT TYPE = "hidden" name = MID value = "<?php echo $MID;?>">

                                    <INPUT TYPE = "hidden" name =MIDpage value = "<?php echo $MIDpage;?>">

                                    <table width = "<?php echo $_TBWIDTH;?>" border = "0" cellspacing = "1" cellpadding = "4" align = "center" bgcolor = e3e3e3>

                                        <tr>

                                            <td>

                                                <?php echo getlang("ประเภทวัสดุ::l::Material type"); ?></td>

<td><?php  
$thismdtype=getval("config","defaultresource_codeserial");
if ($mode=="bounditem") {
	 $thismdtype=getval("MARC","serial-bound-mdtype");
}
frm_restype("RESOURCE_TYPE", $thismdtype);

?></td></tr>

										  <tr>
                                            <td>
                                                <?php echo getlang("วัสดุของห้องสมุด::l::At Library campus"); ?></td>
                                            <td><?php  
                                            frm_libsite("FLIBSITE");
                                        ?></td></tr>
<tr>
<td>
	<?php echo getlang("สถานที่จัดเก็บ::l::Shelve"); ?></td>
<td>
<?php  
//print_r($editing);
frm_itemplace("itemplace","","","serial");
?>

</td></tr>

										  <tr>
                                            <td>
                                                <?php echo getlang("สถานะ::l::Status"); ?></td>
                                            <td><?php  

frm_genlist("Fstatus","select * from media_mid_status order by code","code","name","-localdb-","yes","");
                                        ?></td></tr>
    <tr bgcolor = "#f3f3f3">
      <td  colspan=2>
<SCRIPT LANGUAGE="JavaScript">
	<!--
			startrunning=0
			<?php  
			$s=tmq("select * from media_mid where pid='$MID' "); 
			?>;
	//-->
</SCRIPT>

	  <TABLE cellpadding=0 cellspacing=0 width=100%>
	  <TR valign=top>
		<TD><span ID="BCRESULT"></span></TD>
		<span ID="BCSOURCE">
		<nobr><?php echo getlang("เลขทะเบียน::l::Code"); ?> <input style="width:130" type = text name="REPLACETABEAN[]" ID="tabean[RANDOMHERE]" onkeydown="return localbckeydown2(event,this);">
		<img border=0 align=absmiddle src="<?php echo $dcrURL?>neoimg/Left16.gif" style="cursor: hand; cursor: pointer;" onclick="getobj('tabean[RANDOMHERE]').value=getobj('text[RANDOMHERE]').value"> 
	Barcode <input type = text ID="text[RANDOMHERE]" name = "REPLACETHIS[]" 
		onkeydown="return localbckeydown(event,this)";
		onkeyup="getobj('bcchecker[RANDOMHERE]').src='bccheck.php?bc='+this.value;"	
		onmousedown="getobj('bcchecker[RANDOMHERE]').src='bccheck.php?bc='+this.value;"				
		 style="width:150">
		 		<img border=0 align=absmiddle src="<?php echo $dcrURL?>neoimg/favbadd16.png" style="cursor: hand; cursor: pointer;" onclick="getobj('bcchecker[RANDOMHERE]').src='../library.bitem/getnextbc.php?parentid='+escape('text[RANDOMHERE]')+'&randid='+Math.random(); "> 

		<?php echo getlang("ฉบับ::l::Copy"); ?>
			<input type = text name="REPLACEINUMMER[]" value="" ID="inumber[RANDOMHERE]" onkeydown="return localbckeydown2(event,this);" size=8>
			<iframe src="" width=130 height=25 frameborder=0 SCROLLING=NO ID='bcchecker[RANDOMHERE]'></iframe>
			</nobr>
		</span>

	  </TR>
		
	  </TABLE>
		<?php  
		include("local.bcjsfunc.php");?>
	 </td>
    </tr>
<?php  	if ($mode!="bounditem") {
?>
    <tr bgcolor = "#f3f3f3">
      <td width = "27%" valign = "middle">
      <font face = "MS Sans Serif" size = "2" style='color: darkred'><?php echo getlang("ไม่เพิ่มไอเทม::l::No items"); ?><br> </font>
	  </td>
      <td width = "73%"><INPUT TYPE="checkbox" NAME="forcenoitem" value='yes'></td>
    </tr><?php  }?>
    <tr bgcolor = "#f3f3f3">
      <td width = "27%" valign = "middle">
      <font face = "MS Sans Serif" size = "2"><?php echo getlang("ราคา::l::Price"); ?><br> </font>
	  </td>
      <td width = "73%">
<input type = text name = "price" value="<?php 
if ($mode=="bounditem") {
	echo $sumprice;
} else {
   echo "0";
}
?>" > <?php  
	  bitem_pricehelp($MID);
	  ?></td>
    </tr>

    <tr bgcolor = "#f3f3f3">
      <td width = "27%" valign = "middle">
      <font face = "MS Sans Serif" size = "2"><?php echo getlang("ฉบับที่::l::Copy"); ?><br> </font></td>
      <td width = "73%">
    <font face = "MS Sans Serif" size = "2">




	<?php  
	echo "".getlang("วัสดุนี้ มีจำนวน::l::Already")." ".tmq_num_rows($s) . " ".getlang("รายการในฐานข้อมูล::l::Items in database")."";
	?>

	</font></td>
    </tr>

<TR valign=top bgcolor=white>
	<TD  class=table_td>enumeration </TD>
	<TD><?php 
		$sr=tmq("select * from serial_info where mid='$MID' ",false);
		$sr=tmq_fetch_array($sr);
		if ($boundvar[jenum_1]=="" && $editing[jenum_1]=="") {
			$boundvar[jenum_1]=$next_dat_enum1;
		}
		if ($boundvar[jenum_2]=="" && $editing[jenum_2]=="") {
			$boundvar[jenum_2]=$next_dat_enum2;
		}
		if ($boundvar[jenum_3]=="" && $editing[jenum_3]=="") {
			$boundvar[jenum_3]=$next_dat_enum3;
		}
		?><?php  echo getlang($sr[enum1]); ?>
		<INPUT TYPE="<?php  if (trim($sr[enum1])!="") { echo "text";}  else {echo "hidden";}?>" NAME="jenum_1" size=10 value="<?php echo $boundvar[jenum_1].$editing[jenum_1]?>"> 
		<?php  echo getlang($sr[enum2]); 
			if (trim($sr[enum2])!="") {
				//echo $sr[enumr2];
				if ("$sr[enumr2]"=="-1") {
					?> <input type="text" name="jenum_2" size=5 value="<?php echo floor($boundvar[jenum_2]);?>"> <?php  
				} else {
				?>
				<SELECT NAME="jenum_2"><option><?php  
					$tmpa=explode(',',$sr[enumr2]);
					while (list($sk,$sv)=each($tmpa)) {
						$sl=""; if ($boundvar[jenum_2].$editing[jenum_2]==$sv) {$sl=" selected";}
						echo "<option value='$sv' $sl>$sv";
					}
				?>
				</SELECT>
				<?php  }?>
			<?php } else { ?><INPUT TYPE="hidden" NAME="jenum_2" size=10 value="<?php echo $boundvar[jenum_2].$editing[jenum_2]?>"><?php  }?>
<?php  echo getlang($sr[enum3]); 
			if (trim($sr[enum3])!="") {
				if ("$sr[enumr3]"=="-1") {
					?> <input type="text" name="jenum_3" size=5 value="<?php echo floor($boundvar[jenum_3]);?>"> <?php  
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
				<?php  }?>
			<?php } else { ?><INPUT TYPE="hidden" NAME="jenum_3" size=10 value="<?php echo $boundvar[jenum_3].$editing[jenum_3]?>"><?php  }?><BR>
	 <INPUT TYPE="hidden" NAME="jenum_4" size=10 value="<?php echo $boundvar[jenum_4].$editing[jenum_4]?>">
	 <INPUT TYPE="hidden" NAME="jenum_5" size=10 value="<?php echo $boundvar[jenum_5].$editing[jenum_5]?>">
	 <INPUT TYPE="hidden" NAME="jenum_6" size=10 value="<?php echo $boundvar[jenum_6].$editing[jenum_6]?>">
	</TD>
</TR>
<TR valign=top bgcolor=white>
	<TD  class=table_td>chronology </TD>
	<TD>
	<?php  
	 echo getlang("ปี ::l:: Year "); 
	form_quickedit("jchrono_1",$editing[jchrono_1].$next_yea,"year");
	 echo getlang("เดือน ::l:: Month "); 
	form_quickedit("jchrono_2",$editing[jchrono_2].$next_mon,"month");
	 echo getlang("วันที่ ::l:: Date "); 
	if ($next_dat_skipdat=="yes") {
		 $usenextdat="";
	} else {
		$usenextdat=$editing[jchrono_3].$next_dat;
	}
	form_quickedit("jchrono_3",$usenextdat,"day");
	?>
 	<INPUT TYPE="hidden" NAME="jchrono_4" size=10 value="<?php echo $editing[jchrono_4]?>"> 
	</TD>
</TR>
<?php  	if ($mode=="bounditem") {
	//printr($boundvar);
?>
<TR valign=top bgcolor=white>
	<TD  class=table_td><B>Bound's Call number</B></TD>
	<TD>
	<TEXTAREA NAME="calln" ROWS="3" COLS="50"><?php  
	echo $firstcalln."-".$lastcalln;
?></TEXTAREA>
	</TD>
</TR>
<?php  }?>
<TR valign=top bgcolor=white>
	<TD  class=table_td>Availability status note</TD>
	<TD>
	<TEXTAREA NAME="javaistatusnote" ROWS="3" COLS="50"><?php echo $boundvar[javaistatusnote].$editing[javaistatusnote]?></TEXTAREA>
	</TD>
</TR>
<TR valign=top bgcolor=white>
	<TD  class=table_td>Public note </TD>
	<TD>
	<INPUT TYPE="text" NAME="jpublicnote" size=15 id=jpublicnote value="<?php echo $boundvar[jpublicnote] . $editing[jpublicnote]?>"> 
	<A HREF="javascript:void(0)" onclick="document.all.jpublicnote.value='' " class=a_btn style='color: black;'><?php echo getlang("ไม่มีโน๊ต::l::no note");?></A>
	<A HREF="javascript:void(0)" onclick="document.all.jpublicnote.value='Bound' " class=a_btn style='color: darkgreen;'>Bound</A>
	
	</TD>
</TR>
    <tr bgcolor = "#f3f3f3">
      <td width = "27%" valign = "middle">
      <B><font face = "MS Sans Serif" size = "2">Note & status</font></B>
	  </td>
      <td width = "73%">
<input type = text name = "jnonpublicnote" value='<?php echo $editing[jnonpublicnote]?>' id=jnonpublicnote>
	<A HREF="javascript:void(0)" onclick="document.all.jnonpublicnote.value='' " class=a_btn style='color: black;'><?php echo getlang("ไม่มีโน๊ต::l::no note");?></A>
	<A HREF="javascript:void(0)" onclick="document.all.jnonpublicnote.value='Expected' " class=a_btn style='color: #6D1D1D;'>Expected</A>
	<A HREF="javascript:void(0)" onclick="document.all.jnonpublicnote.value='Late' " class=a_btn style='color: #660066;'>Late</A>

	</td>
    </tr>	

   <tr bgcolor = "#e3e3e3">

     <td width = "27%" valign = "top">

     &nbsp;</td>

     <td width = "73%">

        <font face = "MS Sans Serif" size = "2">
		<input type = "submit" name = "Submit2" value = "<?php echo getlang("เพิ่มข้อมูล::l::Submit"); ?>">
		<input type = "reset" name = "Reset" value = "<?php echo getlang("ลบข้อมูล::l::Reset"); ?>">
		<input type = "hidden" name = "sid" value = "<?php echo $sid;?>">
		<A HREF = "serial-items.php?MID=<?php  echo $MID?>"><B>Back</B></A> </font></td>

                                        </tr>

                                    </table>
<INPUT TYPE="hidden" name=mode value="<?php echo $mode?>">
                                </form>


<?php  
foot();
?>