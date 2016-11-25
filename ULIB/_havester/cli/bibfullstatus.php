<?php 
set_time_limit(0);
header("Content-Type: text/html; charset=utf-8");
ob_start();

include("../../inc/config.inc.php");
include("./_conf.php");
include("../enc.php");

$prevlang=$_SESSION['lang_control_val'];
//$_SESSION['lang_control_val']="en";
		$itd=tmq("select * from media_mid where pid='$bibid' ");

  $sql2 ="SELECT *  FROM media_mid where pid='$bibid' order by inumber,id"; 
//echo $sql2; 
$r2 = tmq($sql2);
$_TBWIDTH=1000;

echo ("<table border=1 bordercolor=666666 cellpadding=0 width='100%' align=center bgcolor=666666 cellspacing=1  class=table_border>
<Tr >
	<td width=5% class=table_head><B><nobr>str_no</B></td>
	<td align=center width=10% class=table_head><B><nobr>str_type</B></td>
 	<td align=center width=40% class=table_head colspan=2><B><nobr>str_CallNumber</B>/<B><nobr>str_barcode</B></td>
	<td align=center class=table_head><B><nobr>str_shelf</B></td>
  <td align=center class=table_head><B>str_status</B></td>
</tr>");

$i2=1;
  while ($r = tmq_fetch_array($r2)) {
	  $mMID=$r[bcode];
//  echo "/ /$row2/ /";
if ($r[bcode]==$item) {
	$bg=" style='background-color:#FFE6E7;' ";
	$star="**";
} else {
	$bg=" style='background-color:white;' ";
	$star="";
}
////ishide also on html_displayserial() start
if (loginchk_lib("check")==false) {
	$rectype=tmq("select * from media_type where code='$r[RESOURCE_TYPE]'  ");
	$rectype=tmq_fetch_array($rectype);
	if ($rectype[ishide]=='yes') {
		continue;
	}
	$midstat=tmq("select * from media_mid_status where code='$r[status]'  ");
	$midstat=tmq_fetch_array($midstat);
	if ($midstat[ishide]=='yes') {
		continue;
	}
}
////ishide also on html_displayserial() end
//printr($r);
 echo "<tr >
  <td $bg class=table_td align=right><FONT class=smaller2>$i2.</FONT></td>
	<td $bg class=table_td align=center><img border=0 width=24 height=24 src='";
	if ($r[status]=="reservmat") {
		$usecode="reservmat";
	} else {
		$usecode=$r[RESOURCE_TYPE];
	}
	if (file_exists("$dcrs/_tmp/mediatype/$usecode.png")==true) {
		echo "$dcrURL/_tmp/mediatype/$usecode.png";
	} else {
		echo "$dcrURL/_tmp/mediatype.png";
	}
	echo "' alt='".getlang($rectype[name],"en")."'><BR><FONT class=smaller2>".get_media_type($usecode)."</FONT>";
if ($r[status]!="") {
	echo " <BR> <FONT class=smaller2 COLOR='#002F5E'>".getlang("สถานะ::l::Status")."=".get_mid_status($r[status])."</FONT>";
}
  echo " </td>";

$t02=marc_getmidcalln($r[bcode]);
///$t02=marc_getcalln($ID);

$inumber=$r[inumber];
if (trim($inumber)=="ฉ.1") {
	$inumber="";
}
if (trim($inumber)=="ฉ.") {
	$inumber="";
}
if (trim($inumber)=="") {
	$inumber="";
}
$inumber=str_replace("ฉ","str_chor",$inumber);
echo "<td nowidth=1% nowidth=2 $bg  class=table_td  align=left colspan=2>$t02&nbsp;$inumber&nbsp;$star <BR>";
echo "	<FONT class=smaller2>&nbsp;&nbsp;Barcode: $r[bcode]</FONT> </td>		";
echo "	<td $bg class=table_td  align=center><FONT class=smaller>";
echo get_itemplace_name($r[place],'<BR>&#9658;');
echo " </FONT></td>";

$ecstat=bitem_get_checkoutstr($mMID);
 echo "<TD $bg class=table_td  align=center>";
 echo $ecstat;

 	html_displayrqitem($mMID,$r[place]);

	$hrs=getval("config","timetocirputtoshelf");

  if (floor($r[lastcheckin]+(60*60*$hrs))>time()) {
  	 echo "<br /><font color='#cc3333'><i>*";
  	 echo getlang("เพิ่งรับคืน::l::At circulation desk");
  	 echo "</i></font>";
  }
//////////start is midstatus hide  also on html_displayserial() 
/*
$midstat=tmq("select * from media_mid_status where code='$r[status]'  ");
$midstat=tmq_fetch_array($midstat);
if ($midstat[ishide]=='yes') {
	echo "<BR><FONT class=smaller2>".getlang("รายการนี้ถูกซ่อนจากผู้ใช้::l::This item hidden from users")."</FONT>";
}
*/
//////////end is midstatus hide  also on html_displayserial() 
 echo "</td>";
$i2 +=1;
///////////admin ที่จะลบ
//////////////////////////////////////////////ขอยืมรายการ
///////////////////////////////////////////////จบขอยืม
echo "</tr>";

bitem_get_chaininfo($ID,$r[id]);


if (trim($r[note])!="") {
	echo "<tr bgcolor=white  class=table_td><td></td><td colspan=6 class=smaller style=\"padding: 3px;border-width: 1px; border-style: solid; border-color: aaaaaa\"><B class=smaller>Note:</B>$r[note]";
	echo "</td></tr>";
}

}
//echo "$i2";

if ($i2==1) {
  echo "<tr	bgcolor=white><td colspan=7 align=center  class=table_td>- "."str_noitem"."  - </td></tr>";
}
echo "</table>";
           ?>

 <?php 
	$_SESSION['lang_control_val']=$prevlang;
	$tmp=ob_get_contents();
	ob_end_clean();

	echo myencode($tmp);

?>