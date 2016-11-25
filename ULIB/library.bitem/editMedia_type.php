<?php 
;
     include("../inc/config.inc.php"); 
	head();
	include("_REQPERM.php");
	mn_lib();
            $sql="select * from media_mid where id='$ID'";
            $result=tmq( $sql);
            $Num=tmq_num_rows($result);
            if ($Num == 0)
                {
                echo "<font s><br>No Media_Type ID $ID</font>";
                exit;
                }
            else
                {
					pagesection("แก้ไขรายละเอียดไอเทม::l::Edit item");
                $row=tmq_fetch_array($result);
                $name=$row["name"];
                $id=$row["id"];
        ?>
                    </b></font>
<CENTER>
                    <form method = "post" action = "editMedia_typeAction.php" name = "webForm">
                        <INPUT TYPE = "hidden" name = MID value = "<?php  echo $MID;?>">
                        <INPUT TYPE = "hidden" name =remotes_row value = "<?php  echo $remotes_row;?>">
						
                        <table width = "780" align=center border = "0" bgcolor = e3e3e3>
<script>
startrunning=0
</script>
<tr>
<td align=right>
<?php  echo getlang("ประเภทวัสดุ::l::Material type"); ?></td>
<td><?php 
$resjsid="r".randid();
$placejsid="p".randid();

frm_restype("RESOURCE_TYPE", "$row[RESOURCE_TYPE]","NO",$resjsid);
?>

<script type="text/javascript">
<!--
tmp=getobj("<?php  echo $resjsid; ?>");
tmp.addEventListener("change", reschange, false);
function localblinkplace() {
	tmpplaceblink=getobj("<?php  echo $placejsid; ?>");
	tmpplaceblink.style.borderWidth="2px";
	tmpplaceblink.style.borderColor="red";
	setTimeout("localblinkplace_off();",500);
}
function localblinkplace_off() {
	tmpplaceblink=getobj("<?php  echo $placejsid; ?>");
	tmpplaceblink.style.borderWidth="1px";
	tmpplaceblink.style.borderColor="black";
}
function reschange(e) {
	tmpres=getobj("<?php  echo $resjsid; ?>");
	rescode=tmpres.options[tmpres.selectedIndex].value;
	//alert(rescode);
		//alert(tmpplace.options[i].text+" "+selectobject.options[i].value)
	// pull from db
<?php 

	$s=tmq("select * from media_place where 1 ");
	while ($r=tfa($s)) {
		$deffor=tmq("select * from media_place_defformattype where placecode='$r[code]' and libsite='$LIBSITE' ");
		if (tnr($deffor)==0) {
			continue;
		}
		$chkvaluejs="";
		while ($defforr=tfa($deffor)) {
			$chkvaluejs=$chkvaluejs."rescode==\"$defforr[mediatypecode]\" ||";
		}
		$chkvaluejs=rtrim($chkvaluejs,"||");
		?>
		if (<?php  echo $chkvaluejs;?>) {
		tmpplace=getobj("<?php  echo $placejsid; ?>");
		tmpplace.selectedIndex=0;
		for (var i=0; i<tmpplace.length; i++){
			if (tmpplace.options[i].value=="<?php  echo $r[code];?>") {
			//if (<?php  echo $chkvaluejs;?>) {
				tmpplace.selectedIndex=i;
				localblinkplace();
				return;
			}
		}
	}
			
		<?php 
		}
	?>
	//alert(e);
}
//-->
</script></td></tr>
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
frm_itemplace("itemplace",$row[place],"","",$placejsid);
?>
</td></tr>
<tr><td align = "right" width = "30%">
<b><font color = "#FF0000">*</font></b><?php  echo getlang("เลขทะเบียน::l::Code"); ?>  :
</td>
<td ><input type = "text" name = "tabean" size = "50" value = "<?php  echo "$row[tabean]"; ?>">
</td></tr>
<tr><td align = "right" width = "30%">
<b><font color = "#FF0000">*</font></b><?php  echo getlang("เลขเรียก::l::Call Number"); ?>  :
</td>
<td ><input type = "text" name = "calln" size = "15" value = "<?php  echo "$row[calln]"; ?>">
<font class=smaller><?php  echo getlang("ถ้าไม่ใส่จะแสดงเลขเรียกเดียวกับ Bib.::l::leave empty to use same Call Number as Bib."); ?></font>
</td></tr>


 <tr>
   <td align = "right" >
   <b><font color = "#FF0000">*</font></b> Barcode :
   </td>
  <td >
	  <TABLE cellpadding=0 cellspacing=0 width=100%>
	  <TR valign=top>
		<TD><input type = text name = "bcode" value = "<?php  echo "$row[bcode]"; ?>"
		 onblur="getobj('bcchecker').src='bccheck.php?bc='+this.value+'<?php echo "&forceskip=".urlencode($row[bcode])?>';"
		 onkeyup="getobj('bcchecker').src='bccheck.php?bc='+this.value+'<?php echo "&forceskip=".urlencode($row[bcode])?>';"
		  onkeydown="return localbckeydown(event,this);"
		
		></TD>
		<TD><?php 
		$_bcjsfunc_skipmulti="yes";
		include("local.bcjsfunc.php");
		?><iframe src="" width=300 height=25 frameborder=0 SCROLLING=NO ID='bcchecker'></iframe></TD>
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
 <tr>   <td align = "right" >
   <b><font color = "#FF0000">*</font></b> Note :   </td>
  <td >  <input type = "text" name = "note" size = "50" value = "<?php  echo "$row[note]"; ?>" ID='itemnote' >   <br>
  
   <?php 
$qn=getval("catconfig","bibitemquicktext");
$qn=explodenewline($qn);
$qn=arr_filter_remnull($qn);
//printr($qn);
@reset($qn);
while (list($qnk,$qnv)=each($qn)) {
	?><a href="javascript:void(null);" onclick="tmp=getobj('itemnote'); tmp.value='<?php  echo stripslashes($qnv);?>'; " class="smaller2 a_btn"><?php  echo stripslashes($qnv);?></a> <?php 
}
	  ?>
	  
	  </td>   </tr>
 <tr>   <td align = "right" >
   <b><font color = "#FF0000">*</font></b> Admin. Note :   </td>
  <td >  <input type = "text" name = "adminnote" size = "50" value = "<?php  echo "$row[adminnote]"; ?>">    </td>   </tr>
   
   <tr>
   <td align = "right" >
   <b><font color = "#FF0000">*</font></b> Status :
   </td>
  <td >
<SELECT NAME="status">
<option value="">ปกติ<?php 
$s=tmq("select * from media_mid_status order by name");
while ($r=tmq_fetch_array($s)) {
	$sl="";
	if ($r[code]==$row[status]) {
		$sl="selected";
	}
   $r[name]=str_replace("()","",$r[name]);
	echo "<option value='$r[code]' $sl>".getlang($r[name]);
   if (trim($r[code])!="") {
      echo "($r[code]) ";
   } 
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
 </td> </tr></table>
 <input type = "submit" name = "Submit" value = "<?php  echo getlang("ตกลง::l::Submit"); ?>">
 <input type = "reset" name = "Submit2" value = "<?php  echo getlang("ยกเลิก::l::Reset"); ?>">
 <input type = "hidden" name = "mid" value = "<?php  echo "$ID"; ?>">
		<input type = "hidden" name = "remotes_row" value = "<?php  echo $remotes_row;?>">
 <A HREF = "media_type.php?MID=<?php echo $MID?>&remotes_row=<?php echo $remotes_row?>"><B>Back</B></A>
                    </form>
</CENTER>
                    <br>
					<?php 
				}
	 foot();?>