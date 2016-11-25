<?php 
include("./cfg.inc.php");
include("./_localfunc.php");
     head();
	mn_web("webboard");
$ismanager=loginchk_lib("check");

$now=time();
$sql2 ="SELECT *  FROM webboard_boardcate where 1 "; 
if ($ismanager!=true) {
	$sql2 = "$sql2 and isshowtouser='yes' ";
}
$sql2 = "$sql2 order by ordr,name";

$s=tmq($sql2);
 echo "<TABLE width=780 align=center>
<TR>
	<TD><B style=\"font-size: 22px;\">".getlang(barcodeval_get("webboard-boardname"))."</B></TD>
</TR>
</TABLE>";

pathgen("index");

?>
<TABLE cellpadding=3 cellspacing=1 bgcolor=black align=center width="<?php  echo $_TBWIDTH;?>" class=table_border>
<TR bgcolor=eeeeee>
	<TD width=50  class=table_head><B>&nbsp;</B></TD>
	<TD width=70%  class=table_head><B><?php  echo getlang("หัวข้อ::l::Category");?></B></TD>
	<TD  class=table_head><B><?php  echo getlang("โพสท์ล่าสุด::l::Last post");?></B></TD>
</TR>
<?php  
	while ($r=tmq_fetch_array($s)) {
?>
<TR bgcolor=white>
	<TD align=center valign=middle><?php 
		$img="green";
?><IMG SRC="./<?php  echo $img?>.gif" BORDER="0" <?php  echo $_topicstatus[$img];?>></TD>

	<TD class=table_td>
	<?php 
	if ($img=='protection' && $ismanager!= true)	 {
		$link="<a href='javascript:void(0);' onclick='alert(\"".getlang("ขออภัย ท่านไม่มีรายชื่อในการเข้าดูหัวข้อนี้::l::Sorry, you cannot view this forum")."\");'>";
	} else {
		$link="<A HREF='viewforum.php?ID=$r[id]'>";
	}
		echo $link;
	?><B style='font-size: 20px;'><B></B><?php  echo getlang($r[name])?></B><BR>&nbsp;&nbsp;<B></B><?php  echo getlang($r[descr]);?></A> 
	<?php 
	if ($r[isshowtouser]!="yes") {
		echo getlang("แสดงให้เจ้าหน้าที่เห็นเท่านั้น::l::Librarian only");
	}	
	?>
</TD>
	<TD align=center class=table_td style='font-size: 12px;'><?php 
	$tmp=tmq("select * from webboard_posts where boardid='$r[id]' and ishide<>'yes' order by lastactive desc,id desc limit 1 ");
	if (tmq_num_rows($tmp)==0) {
		echo "-";
	} else {
		$tmp=tmq_fetch_array($tmp);
		echo ymd_datestr($tmp[lastactive]);
		if ($tmp[tmid]!="") {
			echo "<BR>".getlang("โดย::l::By")." ".html_library_name($tmp[tmid]);
		} else {
			echo "<BR>".getlang("โดย::l::By")." <B  style='font-size: 12px;'>ผู้เยี่ยมชม</B>";
		}
	}

	?>

	</TD>
</TR>

<?php 
	}	
?>
</TABLE><?php 
pathgen("index");
?><center>[<A HREF="search.php" class=localpathgenlink><img src="search.gif" align=absmiddle border=0><?php  echo getlang("ค้นหาในเว็บบอร์ด::l::Webboard search");?></A>]</center>
<center>
<br /><a href="../getfeed.php?feed=webboardnewest" class=feedbtn><img align=absmiddle src="../neoimg/feed-icon-14x14.png" border=0> <?php  echo getlang("Feed โพสท์ใหม่::l::Feed newest posts");?></a>
</center><?php 


foot();

?>