                <div align = "center">
                    <br>
                    <br>
                    <center>
                        <b><font color = red size = +1><?php  echo getlang("กรุณาใส่ข้อมูลสำหรับสืบค้น::l::Please enter something to search"); ?>
</font></b> <a href="<?php  echo $_PAGE_FILEBACK;?>"><B><?php  echo getlang("สืบค้นใหม่::l::New search"); ?></B></a><BR><BR>
<TABLE align=center>
<TR>
	<TD><?php 
	$gstr=getlang("เรียงตามชื่อเรื่อง::l::By Title").",./search-browse-title.php,gray,_self,".getlang("เปิดดูข้อมูลทั้งหมด โดยเรียงตามชื่อเรื่อง::l::Browse all database, sorted by Title");
 	$gstr.="::".getlang("เรียงตามผู้แต่ง::l::By Author").",./search-browse-author.php,gray,_self,".getlang("เปิดดูข้อมูลทั้งหมด โดยเรียงตามผู้แต่ง::l::Browse all database, sorted by Author");
	$gstr.="::".getlang("หัวเรื่อง::l::Subjects").",./search-browse-subject.php,gray,_self,".getlang("เปิดดูข้อมูลหัวเรื่องทั้งหมด ::l::Browse all subject in database");
	html_guidebtn($gstr);

	?></TD>
</TR>
</TABLE>
</center>

                </div>
				<?php 
				
				?>