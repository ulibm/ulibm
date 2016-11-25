<?php 
include("./inc/config.inc.php");
include("./index.inc.php");

head();
mn_web("collections");

//printr($usecollection);

pagesection(getlang("กรุณาเลือกคอลเลกชั่นที่ต้องการสืบค้น::l::Please choose collections to search from"));
	if ($someyes!="yes") {
		//html_dialog("",getlang("กรุณาเลือกคอลเล็กชัน::l::Please choose some collection"));
	} else {
		html_dialog("Success",getlang("บันทึกค่าเรียบร้อยแล้ว::l::Collection selected") . "   ..<A HREF='index.php'><B>".getlang("กลับหน้าสืบค้น::l::Back to search form")."</B></A>");
	}
?><BR>
<TABLE width=500 align=center cellpadding=0 cellspacing=0>
<FORM METHOD=POST ACTION="collections.php">
<INPUT TYPE="hidden" NAME="save" value="yes">
	<?php 
$s=tmq("select * from collections order by name");
while ($r=tmq_fetch_array($s)) {
?><TR valign=top>
	<TD width=64><?php 
	echo "<img src='$dcrURL/neoimg/collectionicon/$r[icon]' width=64 height=64>";

?></TD>
	<TD align=left width=100%>
	<B style='font-size: 24px; '><?php  echo getlang($r[name])?></B><BR>
	<?php  echo getlang($r[descr])?></TD>
</TR>
<TR valign=top>
	<TD align=right colspan=2 width=100%>
<A HREF="collections.php?collist[<?php echo $r[id]?>]=okyes&save=yes" class="a_btn smaller"><?php  echo getlang("สืบค้นคอลเล็กชันนี้::l::Search this collection");?></A> ::
<a href="./getfeed.php?feed=collection&collectionid=<?php  echo $r[classid]?>" target=_blank class=feedbtn><img align=absmiddle src="./neoimg/feed-icon-14x14.png" border=0> 
<?php  echo getlang("รับ Feed ของคอลเล็กชั่นนี้::l::Get collection feed");?></a><BR><BR></TD>
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
</FORM>
</TABLE>
<?php 
foot();
?>