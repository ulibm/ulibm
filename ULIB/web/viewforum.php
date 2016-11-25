<?php 
;
if ($ID=="index") {
	include("index.php");
	die;
}
if ($ID=="search") {
	include("search.php");
	die;
}
include("./cfg.inc.php");
include("./_localfunc.php");
               
     head();

	 mn_web($_REQPERM);

	$ismanager=library_gotpermission("webpage-postarticle");
	 $ID=trim($ID);

	$catedata=tmq("select * from  webpage_menu where id='$ID' ");
	$catedata=tmq_fetch_array($catedata);


pagesection(getlang($catedata[name]));

$sarticledescr=tmq("select * from webpage_menu_articledescr where refid='$ID' ");
$sarticledescr=tmq_fetch_array($sarticledescr);
?>
<table width="<?php  echo $_TBWIDTH?>" align=center><tr><td><?php 
echo $sarticledescr[text]
?></td></tr></table><?php ?><?php 
pathgen($ID);

$now=time();
?>
<TABLE cellpadding=1 cellspacing=1 bgcolor=black align=center width="<?php  echo $_TBWIDTH?>" class=table_border>
<?php 
$suse="select * from webpage_articles where nestedid=0 and boardid='$ID' and ispin<>'yes' ";
if ($ismanager!=true) {
	$suse.= " and ishide<>'yes' ";
}
//$suse.= " order by lastactive desc ";//desc
if ($catedata[orderby]=="lastactive") {
	$suse.= " order by lastactive desc ";//desc
} 
if ($catedata[orderby]=="topicname") {
	$suse.= " order by topic asc ";//desc
}
//echo $suse;
echo "<!--";
//$suse=tmqp($suse,"viewforum.php?ID=$ID");
$suse=tmq($suse);

echo "-->";
echo $_pagesplit_btn_var;
?>
<TR bgcolor=eeeeee>
<!-- 	<TD width=100  class=table_head><nobr><B>&nbsp;</B></TD> -->
	<TD width=77%  class=table_head><B><?php  echo getlang("บทความ::l::Articles");?></B></TD>
<!-- 	<TD width=7%  class=table_head><B><?php  echo getlang("Comments");?></B></TD> -->
	<TD width=23%  class=table_head><B><?php  echo getlang("ผู้เขียน::l::Writer");?></B></TD>
	<!-- <TD width=23% class=table_head><B><?php  echo getlang("อัพเดท::l::Last active");?></B></TD> -->
</TR>
<?php 
$row_per_page=getval("pagesplit","pagelength");

$s="select * from webpage_articles where nestedid=0 and boardid='$ID' and ispin='yes' ";
if ($ismanager!=true) {
	$s.= " and ishide<>'yes' ";
}
$s.= " order by lastactive desc ";
$s=tmq($s);
while ($r=tmq_fetch_array($s)) {
	viewtopicrow($r,"pin");
}	

html_rows0_str($suse,"ยังไม่มีข้อความ",6);
while ($r=tmq_fetch_array($suse)) {
	viewtopicrow($r);
}	
echo $_pagesplit_btn_var;
?>
</TABLE>
 <?php 
pathgen($ID);
include("inc.webjump.php");

foot();

?>