<?php 
;
include("./cfg.inc.php");
include("./_localfunc.php");
html_start();
     head(); // พ
		 mn_web("webboard");
$ismanager=loginchk_lib("check");
 $TID=trim($TID);
 $postdata="select * from webboard_posts where id='$TID' ";
 if ($ismanager!=true) {
	$postdata.=" and ishide<>'yes' ";
 }
	$postdata=tmq($postdata);
	if (tmq_num_rows($postdata)==0) {
		die("no webboard_posts id $TID");
	}
	$postdata=tmq_fetch_array($postdata);

if (strpos($postdata[viewers],",$_tmid,")===false) {
	$newviewers=$postdata[viewers].",$_tmid,";
	tmq("update webboard_posts set viewers='$newviewers' where id='$TID' ");
}

$backto=urlencode("viewtopic.php?TID=$TID");
echo "<TABLE width='$_TBWIDTH' align=center>
<TR>
	<TD><B style=\"font-size: 22px;\">$postdata[topic]</B></TD>
</TR>
</TABLE>";

pathgen($postdata[boardid],$TID);

/*
	if ($catedata[isshowtouser]!="yes" && $ismanager!=true) {
		die("you cannot post in this forum");
	}
*/

viewpost($postdata);

$sql="select * from  webboard_posts where nestedid='$TID'  ";
 if ($ismanager!=true) {
	$sql.=" and ishide<>'yes' ";
 }
$sql.="  order by dt asc, ID asc ";
//echo $sql;
?><!--<?php 
$s=tmqp($sql,"viewtopic.php?TID=$TID","skip");
?>--><TABLE width="<?php  echo $_TBWIDTH?>" align=center>
<?php  echo $_pagesplit_btn_var; ?>
</TABLE><?php 
while ($r=tmq_fetch_array($s)) {
	viewpost($r);
}
?><TABLE width="<?php  echo $_TBWIDTH?>" align=center>
<?php  echo $_pagesplit_btn_var; ?>
</TABLE><BR><?php 
pathgen($postdata[boardid],$TID);
?>
<SCRIPT LANGUAGE="JavaScript" src="/counter2?_BOARD">
<!--
//-->
</SCRIPT>

<?php 
foot();
?>