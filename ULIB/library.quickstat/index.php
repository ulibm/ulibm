<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        mn_lib();
?><BR><?php 


			pagesection(getlang("Quick Statistics"));
?><TABLE width="<?php  echo $_TBWIDTH;?>" align=center>
<TR valign=top>
	<TD width=160><?php 
	$s=tmq("select * from quickstat order by name");
	while ($r=tmq_fetch_array($s)) {
		echo "&bull; <A HREF='stat.php?id=$r[id]'  target=dsp class=smaller>".getlang($r[name])."</A><BR>";
	}
	?><BR><HR>
	<div align=right>
	<A HREF="man.stat.php" class="smaller a_btn" target=dsp><?php  echo getlang("เพิ่มลบหัวข้อสถิติ::l::Manage statistic");?></A><BR>
	<A HREF="man.descr.php" class="smaller a_btn" target=dsp><?php  echo getlang("แก้ไขข้อความบรรยาย::l::Manage stat. description");?></A><BR>
	<!-- <A HREF="statsum.php" class="smaller a_btn" target=dsp><?php  echo getlang("ข้อมูลสรุป::l::Summary stat. description");?></A><BR> -->
	
	
	
	</div></TD>
	<TD><iframe name="dsp" width="<?php  echo $_TBWIDTH-160;?>" height=1000></iframe></TD>
</TR>
</TABLE>
<?php 
foot();
?>