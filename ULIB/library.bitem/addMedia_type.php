<?php  
;
     include("../inc/config.inc.php"); 
	head();
	include("_REQPERM.php");
	mn_lib();
	 ?><BR>	
<script>
function timeoutman(wh,whthis) {
if (whthis.timeoutvalue!=undefined) {
  clearTimeout(whthis.timeoutvalue);
}
	whthis.timeoutvalue=setTimeout("getobj('"+wh+"').src='bccheck.php?bc="+whthis.value+"';",1000);
	//alert("getobj('"+wh+"').src='bccheck.php?bc="+whthis.value+"';");
}
</script>
<TABLE width="770" border="0" cellspacing="1" cellpadding="3" align=center>
<TR>
	<TD><?php  
	echo getlang("กำลังจัดการไอเทมของวัสดุฯ::l::Managing Items of Material");
	echo "<BR>";
  res_brief_dsp($MID);	
?></TD>
</TR>
</TABLE>
<table width = "900" align=center border = "0" cellspacing = "0" cellpadding = "0">
<tr valign = "top">
<td>
<form name = "form1" method = "post" action = "addMedia_typeAction.php" >
<INPUT TYPE = "hidden" name = MID value = "<?php echo $MID;?>">
<INPUT TYPE = "hidden" name =remotes_row value = "<?php echo $remotes_row;?>">
<table width = "900" border = "0" cellspacing = "1" cellpadding = "4" align = "center" bgcolor = e3e3e3>
<tr>
<td>
<?php echo getlang("ประเภทวัสดุ::l::Material type"); ?></td>
<td><?php  
		$defrestype=getval("config","defaultresource_code");
		$defrestypesess=sessionval_get("lastrestourcetypeitem");
		if ($defrestypesess!="") {
			 $defrestype=$defrestypesess;
		}
		//echo "[$defrestypesess]";
$resjsid="r".randid();
$placejsid="p".randid();
frm_restype("RESOURCE_TYPE", $defrestype,"NO",$resjsid);
?>

<script type="text/javascript">
<!--
tmp=getobj("<?php echo $resjsid; ?>");
tmp.addEventListener("change", reschange, false);
function localblinkplace() {
	tmpplaceblink=getobj("<?php echo $placejsid; ?>");
	tmpplaceblink.style.borderWidth="2px";
	tmpplaceblink.style.borderColor="red";
	setTimeout("localblinkplace_off();",500);
}
function localblinkplace_off() {
	tmpplaceblink=getobj("<?php echo $placejsid; ?>");
	tmpplaceblink.style.borderWidth="1px";
	tmpplaceblink.style.borderColor="black";
}
function reschange(e) {
	tmpres=getobj("<?php echo $resjsid; ?>");
	rescode=tmpres.options[tmpres.selectedIndex].value;
	//alert(rescode);
		//alert(tmpplace.options[i].text+" "+selectobject.options[i].value)
	// pull from db
<?php  

	$s=tmq("select * from media_place where 1 ");
	while ($r=tfa($s)) {
		$deffor=tmq("select * from media_place_defformattype where placecode='$r[code]' and libsite='$LIBSITE'  ");
		if (tnr($deffor)==0) {
			continue;
		}
		$chkvaluejs="";
		while ($defforr=tfa($deffor)) {
			$chkvaluejs=$chkvaluejs."rescode==\"$defforr[mediatypecode]\" ||";
		}
		$chkvaluejs=rtrim($chkvaluejs,"||");
		?>
		if (<?php echo $chkvaluejs;?>) {
		tmpplace=getobj("<?php echo $placejsid; ?>");
		tmpplace.selectedIndex=0;
		for (var i=0; i<tmpplace.length; i++){
			if (tmpplace.options[i].value=="<?php echo $r[code];?>") {
			//if (<?php echo $chkvaluejs;?>) {
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
</script>
</td></tr>
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

$defresplacesess=sessionval_get("lastrestourceplaceitem");
frm_itemplace("itemplace",$defresplacesess,"","",$placejsid);
?>
</td></tr>
<tr>
<td>
	<?php echo getlang("สถานะ::l::Status"); ?></td>
<td>
<?php  
//print_r($editing);
$defstatussess=sessionval_get("defstatussess");
frm_genlist("status","select * from media_mid_status order by code","code","name","-localdb-","yes",$defstatussess);
//frm_itemplace("status",$defstatussess,"","");
?> 
<a href='javascript:void(null);' class='smaller2 a_btn' 
onclick="tmp=getobj('bcrunningdiv'); tmp.style.display='block';"
>running</a>
<br>
<div ID=bcrunningdiv style='display:none;'>
<?php echo getlang("เริ่มจากบาร์โค้ดหมายเลข::l::Start from barcode number");?> <input type=text ID=bcrunningstartnum><BR>
<?php echo getlang("เป็นจำนวน::l::for");?> <input type=number step=1 ID=bcrunningstartcount size=5 value=10 style="width: 70px;"> <?php echo getlang("หมายเลข::l::barcode");?> <BR>
<?php echo getlang("ตัวอักษรนำหน้าบาร์โค้ด::l::for");?> <input type=text ID=bcrunningprefix size=5 value='' > 


<a href='javascript:void(null);' class='a_btn' 
onclick="processbarcoderunning();"><?php echo getlang("ดำเนินการ::l::OK");?> </a>
</div>
</td></tr>
<script>
function processbarcoderunning() {
   tmp1=getobj("bcrunningdiv");
   //tmp1.style.display='none';
   tmps=getobj("bcrunningstartnum");
   //tmplen=tmps.length;
   tmps=(tmps.value);
   tmpn=getobj("bcrunningstartcount");
   tmpn=parseInt(tmpn.value);
   tmpprefix=getobj("bcrunningprefix");
   tmpprefix=(tmpprefix.value);
   self.location="<?php echo $PHP_SELF."?MID=$MID&remotes_row=$remotes_row";?>&bcrunning=yes&from="+tmps+"&runningfor="+tmpn+"&bcrunningprefix="+tmpprefix;

}
</script>
    <tr bgcolor = "#f3f3f3">
      <td  colspan=2>
<SCRIPT LANGUAGE="JavaScript">
	<!--
			startrunning=<?php  $s=tmq("select * from media_mid where pid='$MID' "); echo (tmq_num_rows($s))?>;
	//-->
</SCRIPT>
	  <TABLE cellpadding=0 cellspacing=0 width=100%>
	  <TR valign=top>
		<TD><span ID="BCRESULT"></span></TD>
		<span ID="BCSOURCE" >
		<nobr class=smaller>
		CallNo. <input type = text name="REPLACECALLN[]" ID="calln[RANDOMHERE]"  class=smaller style="width:90">
		<?php echo getlang("เลขทะเบียน::l::Code"); ?> <input type = text name="REPLACETABEAN[]" ID="tabean[RANDOMHERE]" onkeydown="return localbckeydown2(event,this);" class=smaller style="width:90">
		<img border=0 align=absmiddle src="<?php echo $dcrURL?>neoimg/Left16.gif" style="cursor: hand; cursor: pointer;" 
		onclick="getobj('tabean[RANDOMHERE]').value=getobj('text[RANDOMHERE]').value"> 
		Barcode <input type = text ID="text[RANDOMHERE]" name = "REPLACETHIS[]" 
		onkeydown="return localbckeydown(event,this);"
		onkeyup="timeoutman('bcchecker[RANDOMHERE]',this);"	
		onmousedown="getobj('bcchecker[RANDOMHERE]').src='bccheck.php?bc='+this.value;return true;"			
		style="width:110" class=smaller autocomplete=off>
		<img border=0 align=absmiddle src="<?php echo $dcrURL?>neoimg/favbadd16.png" style="cursor: hand; cursor: pointer;" onclick="getobj('bcchecker[RANDOMHERE]').src='getnextbc.php?parentid='+escape('text[RANDOMHERE]');"> 
		<?php echo getlang("ฉบับ::l::Copy"); ?>
			<input type = text name="REPLACEINUMMER[]" value="" ID="inumber[RANDOMHERE]" onkeydown="return localbckeydown2(event,this);" size=4 class=smaller>
			<iframe src="" width=200 height=25 frameborder=0 SCROLLING=NO ID='bcchecker[RANDOMHERE]'></iframe>
			</nobr>
		</span>
	  </TR>
		
	  </TABLE>
	<?php  
		include("local.bcjsfunc.php");
	?>
	 </td>
    </tr>
    <tr bgcolor = "#f3f3f3">
      <td width = "27%" valign = "middle">
      <font face = "MS Sans Serif" size = "2"><?php echo getlang("ราคา::l::Price"); ?><br> </font>
	  </td>
      <td width = "73%">
<input type = text name = "price" value=0 > <?php  
	  bitem_pricehelp($MID);
	  ?></td>
    </tr>
    <tr bgcolor = "#f3f3f3">
      <td width = "27%" valign = "middle">
      <font face = "MS Sans Serif" size = "2">Note </font>
	  </td>
      <td width = "73%">
<input type = text name = "note" ID='itemnote' value='' > <?php  
$qn=getval("catconfig","bibitemquicktext");
$qn=explodenewline($qn);
$qn=arr_filter_remnull($qn);
//printr($qn);
@reset($qn);
while (list($qnk,$qnv)=each($qn)) {
	?><a href="javascript:void(null);" onclick="tmp=getobj('itemnote'); tmp.value='<?php echo stripslashes($qnv);?>'; " class="smaller2 a_btn"><?php echo stripslashes($qnv);?></a> <?php  
}
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
   <tr bgcolor = "#e3e3e3">
     <td width = "27%" valign = "top">
     &nbsp;</td>
     <td width = "73%">
        <font face = "MS Sans Serif" size = "2">
		<input type = "submit" name = "Submit2" value = "<?php echo getlang("เพิ่มข้อมูล::l::Submit"); ?>">
		<input type = "reset" name = "Reset" value = "<?php echo getlang("ลบข้อมูล::l::Reset"); ?>">
		<A HREF = "media_type.php?MID=<?php  echo $MID?>" class=a_btn><B>Back</B></A> </font></td>
                                        </tr>
                                    </table>
                                </form>
                                <br>
                            </td>
                        </tr>
                    </table>
<?php  
if ($bcrunning=="yes") {
   $len=strlen("".$from);
   //echo "[$len]";
   $bcrunningprefix=trim($bcrunningprefix);
   $from=floor($from);
   $runningfor=floor($runningfor);
      $isfirst="yes";
   for ($i=0;$i<$runningfor;$i++) {
      
      ?><script>duplicatedb("<?php echo $isfirst;?>","<?php 
   echo $bcrunningprefix;
   echo str_fixw($from+$i,$len);
   ?>");</script>
   <?php
   $isfirst="no";
   }
   
}
?>                    
<?php  
foot();
?>