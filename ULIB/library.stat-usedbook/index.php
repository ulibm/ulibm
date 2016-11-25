<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="bookusestat-enter";
    mn_lib();
		$mediaid=trim($mediaid); 
		pagesection("สแกนบาร์โค้ดไอเทมที่ถูกหยิบใช้::l::Enter used item's barcode");
		?><table width=780 align=center class=table_border>
<form action="index.php" method=POST>
<tr><td  class=table_head><input type="text" name=mediaid size=25 ID="MEDIAINPUTFORM"/> <input type="submit" value='Enter'></td></tr>
<tr><td  class=table_head><?php  echo getlang("ที่::l::At");?> <?php 
frm_itemplace("shelfid",$shelfid);
?></td></tr>
<?php if ($mediaid!="") {?><tr><td  class=table_td><?php 
	$c=tmq("select * from media_mid where bcode='$mediaid' ");
	if (tmq_num_rows($c)==0) {
		 echo "Barcode not found [$mediaid]";
	} else {
    $c=tmq_fetch_array($c);
  	res_brief_dsp($c[pid]);
		//echo "";
		stathist_add("used_shelf_book",$mediaid,$shelfid);	
		stathist_add("used_shelf_bib",$mediaid,$c[pid]);	
		$pid=tmq("select * from media_mid where bcode='$mediaid' ",false);
		$pid=tmq_fetch_array($pid);
		$pid=$pid[pid];
		statordr_add("used_book","$pid");

		echo "<BR><BR>Stat Saved";
	}	
?></td></tr> <?php  } ?>
</form>
</table><SCRIPT LANGUAGE="JavaScript">
<!--
	getobj("MEDIAINPUTFORM").focus();;
	getobj("MEDIAINPUTFORM").select();;
//-->
</SCRIPT>
<?php 
                foot();
?>