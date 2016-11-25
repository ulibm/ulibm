<?php 
include("../inc/config.inc.php");
include("../index.inc.php");

head();
mn_web("collections");

//printr($usecollection);

pagesection(getlang("กรุณาเลือกคอลเลกชั่นที่ต้องการสืบค้น::l::Please choose collections to search from"));
	if ($someyes!="yes") {
		//html_dialog("",getlang("กรุณาเลือกคอลเล็กชัน::l::Please choose some collection"));
	} else {
		html_dialog("Success",getlang("บันทึกค่าเรียบร้อยแล้ว::l::Collection selected") . "   ..<A HREF='index.php'><B>".getlang("กลับหน้าสืบค้น::l::Back to search form")."</B></A>");
	}
?><BR><FORM METHOD=POST ACTION="collections.php">

<TABLE width=800 align=center cellpadding=0 cellspacing=0>
<INPUT TYPE="hidden" NAME="save" value="yes">
	<?php 
$s=tmq("select * from collections order by name");
while ($r=tmq_fetch_array($s)) {
?><TR valign=top>
	<TD width=64><?php 
	echo "<img src='$dcrURL/neoimg/collectionicon/$r[icon]' width=64 height=64>";

?></TD>
<TD align=left width=300>
	<B style='font-size: 24px; '><?php  echo getlang($r[name])?></B><BR>
	<?php  echo getlang($r[descr])?></TD>

	<TD align=left colspan=1 width=200>
<A HREF="collections.php?collist[<?php echo $r[id]?>]=okyes&save=yes" class="a_btn smaller"><?php  echo getlang("สืบค้นคอลเล็กชันนี้::l::Search this collection");?></A><BR></TD>
</TR>
<?php 
}	
?>
<TR>
	<TD colspan=2 align=center> <BR><BR>
	<A HREF="collections.php?setall=yes"  class=a_btn><?php  echo getlang("สืบค้นจากทุกคอลเล็กชั่น::l::Search from all");?></A> :: 
	<A HREF="collections.php"  class=a_btn><?php  echo getlang("เลือกค้นหาจากหลายคอลเล็กชั่น::l::Search from multiple collections");?></A>
	
	</TD>
</TR>
</TABLE></FORM>

<?php 
foot();
?>