<?php 
	; 
	include ("../inc/config.inc.php");
	//head();
		if ($switchlibsitesave=="yes") {
			$chk=tmq("select * from  library_site where code='$switchownlibsite_selected' ");
			$chk=tmq_fetch_array($chk);
			$chk=trim($chk[code]);
			if ($chk!="") {
				$LIBSITE=$switchownlibsite_selected;
				ulibsess_register("LIBSITE");
				//$_SESSION[]=$
			}
		}
		
	include("./_REQPERM.php");
	include("../circulation_o/inc.trap.php");
	html_start();
	//mn_lib();
	if ($LIBSITE=="") {
	  ?><center><?php 
	  ?><BR><TABLE cellpadding=0 cellspacing=0 width=500 align=center class=table_border>
<FORM METHOD=POST ACTION="index.php">
<INPUT TYPE="hidden" NAME="switchlibsitesave" value="yes">
	<TR>
		<TD class=table_head colspan=2><?php  echo getlang("เลือกสาขาห้องสมุดที่กำลังปฏิบัติงาน::l::Switch current campus to work on");?></TD>
	</TR>
 <tr valign = "top">
  <td align=center><?php  
	frm_libsite("switchownlibsite_selected",$LIBSITE);
  ?></td>
 </tr>
	<TR>
		<TD class=table_td align=center><INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการ::l::Save Changes"); ?>"></TD>
	</TR>

</FORM>
	</TABLE><?php 
	  ?></center><?php 
	  die;
	}
?>
<TABLE WIDTH=1000 ALIGN=CENTER BORDER=0 CELLPADDING=0 CELLSPACING=0 >
<TR>
<TD><IFRAME HEIGHT=150 WIDTH=300 frameborder=1 SCROLLING=NO src="<?php 
	echo "main.checkin.php";
?>" name="main" ID="main"></IFRAME></TD>
<TD><IFRAME HEIGHT=150 WIDTH=696 frameborder=1 SCROLLING=NO name="display" ID="display"></IFRAME></TD>
</TR>
</TABLE>
<TABLE WIDTH=780 ALIGN=CENTER BORDER=0 CELLPADDING=0 CELLSPACING=0>
<TR>
<TD COLSPAN=2><IFRAME HEIGHT=450 WIDTH=1000 frameborder=1 SCROLLING=AUTO name="working" ID="working"></IFRAME></TD>
</TR></TABLE>
<iframe src="../circulation_o/refresher.php" style="display:none"></iframe>

<?php 
	foot();
?>