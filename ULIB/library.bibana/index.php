<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        $tmp=mn_lib();
			pagesection($tmp);
?><TABLE width="<?php  echo $_TBWIDTH;?>" align=center>
<TR valign=top>
	<TD width=160>
	<A HREF="report.php" class="smaller a_btn" target=dsp><?php  echo getlang("ดูรายงาน::l::View Report");?></A><BR>
	<A HREF="man.redump.php" class="smaller a_btn" target=dsp><?php  echo getlang("ดึงข้อมูลทรัพยากร::l::Re generate data");?></A><BR>
</TD>
	<TD><iframe name="dsp" width="<?php  echo $_TBWIDTH-160;?>" height=1000 src="man.redump.php"></iframe></TD>
</TR>
</TABLE>
<?php 
foot();
?>