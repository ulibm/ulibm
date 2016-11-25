<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        $tmp=mn_lib();
			pagesection($tmp);
			if (trim(barcodeval_get("activateulib-refcode"))=="") {
				html_dialog("Warning","โมดูลนี้จะใช้งานได้ก็ต่อเมื่อติดตั้งโปรแกรมที่ไอพีจริง และลงทะเบียนโปรแกรม ULibM แล้ว");
			}
?><TABLE width="<?php  echo $_TBWIDTH;?>" align=center>
<TR valign=top>
	<TD width=160>
	<A HREF="settings.php" class="smaller a_btn" target=dsp><?php  echo getlang("ตั้งค่า::l::Settings");?></A><BR>
	<A HREF="setjob.php" class="smaller a_btn" target=dsp><?php  echo getlang("ตั้งค่างาน::l::Set Jobs");?></A><BR>
	<A HREF="report.php" class="smaller a_btn" target=dsp><?php  echo getlang("รายงาน::l::Report");?></A><BR>
</TD>
	<TD><iframe name="dsp" width="<?php  echo $_TBWIDTH-160;?>" height=1000 src="report.php"></iframe></TD>
</TR>
</TABLE>
<?php 
foot();
?>