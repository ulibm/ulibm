<?php 
include("../inc/config.inc.php");
	head();
	mn_root("tb_editor");
if ($act=="del") {
	tmq("delete from tb_editor where editorid='$editorid'");
	tmq("delete from  tb_editor_field where editorid='$editorid'");
}
?>
<TABLE width=780 align=center>
<TR>
	<TD><?php 

echo "<B>การแก้ไขตาราง  </B> ";
echo " /  <A HREF=\"preimport.php\">แสดงรายการตารางเพื่อ Import</A>";
echo "<HR>";
$sql="select distinct cate as tmpname from tb_editor order by tmpname,ordr";
$result=tmq($sql);

while ($row=tmq_fetch_array($result)) {
	echo "<BLOCKQUOTE>$row[tmpname]<HR>";
	$s="select * from tb_editor where cate='$row[tmpname]' order by tbname,ordr";
	$s=tmq($s);
	while ($r=tmq_fetch_array($s)) {
		echo "<A HREF='../admin.tb_editor/menu.php?e=$r[editorid]'>$r[editorid]</A>  [<small>ตาราง $r[tbname]</small>] - $r[note] /  <A HREF=list.php?act=del&editorid=$r[editorid] onclick=\"return confirm('sure?');\"><FONT  COLOR=red><B>del</B></FONT></A><BR>";
	}
	echo "</BLOCKQUOTE>";
}


?>
</TD>
</TR>
</TABLE>
<?php 

foot();
?>