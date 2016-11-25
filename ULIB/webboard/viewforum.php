<?php 
;
include("./cfg.inc.php");
if ($ID=="index") {
	include("index.php");
	die;
}
if ($ID=="search") {
	include("search.php");
	die;
}
include("./_localfunc.php");
               
     head();
	mn_web("webboard");
	$ismanager=loginchk_lib("check");
	 $ID=trim($ID);

	$catedata=tmq("select * from  webboard_boardcate where id='$ID' ");
	$catedata=tmq_fetch_array($catedata);

 echo "<TABLE width='$_TBWIDTH' align=center>
<TR>
	<TD><B style=\"font-size: 22px;\">".getlang($catedata[name])."</B><br>
<font class=smaller>	".getlang($catedata[descr])."</font></TD>
</TR>
</TABLE>";
?><?php 
pathgen($ID);

$now=time();
?>
<TABLE cellpadding=3 cellspacing=1 bgcolor=black align=center width="<?php  echo $_TBWIDTH?>" class=table_border>
<?php 
$suse="select * from webboard_posts where nestedid=0 and boardid='$ID' and ispin<>'yes' ";
if ($ismanager!=true) {
	$suse.= " and ishide<>'yes' ";
}
$suse.= " order by lastactive desc ";//desc
//echo $suse;
echo "<!--";
$suse=tmqp($suse,"viewforum.php?ID=$ID");

echo $_pagesplit_btn_var;
echo "-->";
?>
<TR bgcolor=eeeeee>
	<TD width=100  class=table_head><nobr><B><?php  echo getlang("วันที่::l::Date");?></B></TD>
	<TD width=50%  class=table_head><B><?php  echo getlang("คำถามล่าสุด::l::Last post");?></B></TD>
	<TD width=7%  class=table_head><B><?php  echo getlang("ตอบ::l::Replies");?></B></TD>
	<TD width=23%  class=table_head><B><?php  echo getlang("ผู้ถาม::l::Poster");?></B></TD>
	<TD width=23% class=table_head><B><?php  echo getlang("ตอบล่าสุด::l::Last active");?></B></TD>
</TR>
<?php 
$row_per_page=getval("pagesplit","pagelength");

$s="select * from webboard_posts where nestedid=0 and boardid='$ID' and ispin='yes' ";
if ($ismanager!=true) {
	$s.= " and ishide<>'yes' ";
}
$s.= " order by lastactive desc ";
$s=tmq($s);
while ($r=tmq_fetch_array($s)) {
	viewtopicrow($r,"pin");
}	

html_rows0_str($suse,"ยังไม่มีข้อความ::l::No topics",6);
while ($r=tmq_fetch_array($suse)) {
	viewtopicrow($r);
}	
echo $_pagesplit_btn_var;
?>
</TABLE>
 <?php 
pathgen($ID);
?>

<center>[<A HREF="search.php" class=localpathgenlink><img src="search.gif" align=absmiddle border=0><?php  echo getlang("ค้นหาในเว็บบอร์ด::l::Webboard search");?></A>]</center>

<?php 
include("./inc.webboardjump.php");
?><center>
<br /><a href="../getfeed.php?feed=webboard&boardcate=<?php  echo $ID;?>" class=feedbtn><img align=absmiddle src="../neoimg/feed-icon-14x14.png" border=0> <?php  echo getlang("Feed หัวข้อนี้::l::Feed this forum");?></a>
</center><?php 
foot();

?>