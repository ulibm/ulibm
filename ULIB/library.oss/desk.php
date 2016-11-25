<?php 
	; 
		
    include ("../inc/config.inc.php");

		head();
		$_REQPERM="ossmenu";
    mn_lib();
?>
                <div align = "center">
<?php 
//pagesection(getlang("One Stop Service"));
?>
<table border = 0 cellpadding = 0 width="<?php  echo $_TBWIDTH;?>" 
align = center cellspacing=2>
	<tr>
	  <td valign = "top" width=200 bgcolor=f7f7f7>
	&nbsp;&bull; <a href="desk.new.php" target=dsp class=a_btn><?php  echo getlang("คำขอใหม่::l::New Request"); ?></a>
	<div ID=n_new  style="display:inline; font-size:12px;">-</div><br>
	&nbsp;&bull; <a href="desk.new.php?filterstat=processing" target=dsp class=a_btn><?php  echo getlang("กำลังดำเนินการ::l::Processing"); ?></a>
<div ID=n_processing style="display:inline; font-size:12px;">-</div><br>
	&nbsp;&bull; <a href="desk.waitpayment.php" target=dsp class=a_btn><?php  echo getlang("รอการชำระ::l::Pending Payment"); ?></a> <?php  
	echo "";?><div ID=n_waitpayment  style="display:inline; font-size:12px;">-</div><br>
	 &nbsp;&bull; <a href="desk.new.php?filterstat=matsent" target=dsp class=a_btn><?php  echo getlang("ส่งเอกสารแล้ว::l::Material Sent"); ?></a> <?php  
	echo "";?><div ID=n_matsent style="display:inline; font-size:12px;">-</div><br> 
	&nbsp;&bull; <a href="desk.waitpickup.php" target=dsp class=a_btn><?php  echo getlang("รอผู้มารับเอกสาร::l::Wait for Pickup"); ?></a> <?php  
	echo "";?><div ID=n_waitpickup  style="display:inline; font-size:12px;">-</div><br>
	&nbsp;&bull; <a href="desk.new.php?filterstat=done" target=dsp class=a_btn><?php  echo getlang("เสร็จสิ้น::l::Done"); ?></a> <?php  
	echo "";?><div ID=n_done style="display:inline; font-size:12px;">-</div><br>
	&nbsp;&bull; <a href="desk.paid.php" target=dsp class=a_btn><?php  echo getlang("ประวัติการชำระ::l::Payment History"); ?></a> <?php  
	//$c=tmq("select id from oss_req where stat='waitpayment' "); echo "<font class=smaller2>(".number_format(tnr($c)).")</font>";
	echo "";?><br>
	<!-- &nbsp;&bull; <a href="desk.new.php" target=dsp class=a_btn><?php  echo getlang("ประวัติ::l::History"); ?></a><br> -->
	&nbsp;&bull; <a href="desk.report.php" target=dsp class=a_btn><?php  echo getlang("รายงาน::l::Reports"); ?></a><br>
	<br>
	&nbsp;&bull; <a href="index.php" target=_top noclass=a_btn><?php  echo getlang("กลับ::l::Back"); ?></a><br>

</td>
<script language="JavaScript">
<!--
function autoResizeOSS(id){
    var newheight;
    var newwidth;
	//alert(id);

    if(document.getElementById){
		document.getElementById(id).height=25+'px'
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        //newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }
	//alert(newheight+"");
	if (newheight<300) {
		newheight=300;
	}
    document.getElementById(id).height= (newheight) + "px";
    //document.getElementById(id).width= (newwidth) + "px";
}
//-->
</script>
<td valign = "top"  width="<?php  echo floor($_TBWIDTH-200);?>">
<iframe name="dsp" ID=dspiframe width="<?php  echo floor($_TBWIDTH-200);?>" height=100 frameborder=0 onLoad="autoResizeOSS('dspiframe');" src="desk.new.php"></iframe>
 <?php 


?><BR>
</td>
</tr>
</table>
<?php 
				foot();
?>