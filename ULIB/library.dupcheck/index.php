<?php  
set_time_limit(300);
include("../inc/config.inc.php");
head();
include("./_REQPERM.php");
mn_lib();

$tbname="media";

$tags[]="tag245";
$tags[]="tag100";
$tags[]="tag082";
$tags[]="tag020";
$tags[]="tag260";
$tags[]="tag050";
$grouplist= implode(',',$tags);

if ($mergeid!="") {

	reset($tags);
	$t=tmq("select * from media where ID='$mergeid' ");	
	$t=tmq_fetch_array($t);
	$s="select * from media where 1 ";
	while (list($k,$v)=each($tags)) {
		$s.=" and $v='".addslashes($t[$v])."'";
	}
	$c=0;
	$havecount=0;
	$s=tmq($s);
	$master=tmq_fetch_array($s);
	while ($r=tmq_fetch_array($s)) {
		$md=tmq("select id from media_mid where pid='$r[ID]' ");
		if (tmq_num_rows($md)!=0) {
			$havecount=$havecount+1;
		}
		$c=$c+tmq_num_rows($md);
		tmq("update media_mid set pid='$mergeid' where pid='$r[ID]' ");
		tmq("update media_ftitems set mid='$mergeid' where mid='$r[ID]' ");
		tmq("delete from media where ID='$r[ID]' ");
		index_remove($r[ID]);
	}
	$c=$c+1;
	$havecount=$havecount+1;

	html_dialog("",getlang("รวมรายการแล้ว:::l::Merged:") .$c." ".getlang("ไอเทมใน::l::item in ")." $havecount ".getlang("รายการ::l::record")."<BR><A HREF='$dcrURL/dublin.php?ID=$master[ID]' target=_blank>Detail</A>") ;

}

//dsp

echo "<BR>";
$strdsp=getlang("ตรวจสอบจากแท็ก $grouplist::l::Check from tags:$grouplist");
if ($searchtitle!="") {
	$strdsp=$strdsp."<BR>".getlang("ค้นหาในแท็ก 245::l::Search in tag245").":".$searchtitle;
}
html_dialog("",$strdsp);

function localmdtitle($wh) {
	return "<A HREF='../library.book/DBbook.php?keyword=".urlencode(dspmarc(substr($wh[tag245],2)))."' target=_blank>".dspmarc(substr($wh[tag245],2))."</A>/".dspmarc(substr($wh[tag100],2));
}
function localmerge($wh) {
	global $searchtitle;
	return "<A HREF='index.php?mergeid=$wh[ID]&searchtitle=$searchtitle' onclick=\"return confirm('please confirm');\">".getlang("รวม::l::Merge")."</A>";
}
function localcountitem($wh) {
	global $tags;
	reset($tags);
	$t=tmq("select * from media where ID='$wh[ID]' ");	
	$t=tmq_fetch_array($t);
	$s="select * from media where 1 ";
	while (list($k,$v)=each($tags)) {
		$s.=" and $v='".addslashes($t[$v])."'";
	}
	$c=0;
	$havecount=0;
	$s=tmq($s);
	while ($r=tmq_fetch_array($s)) {
		$md=tmq("select id from media_mid where pid='$r[ID]' ");
		if (tmq_num_rows($md)!=0) {
			$havecount=$havecount+1;
		}
		$c=$c+tmq_num_rows($md);
	}
	return $c." ".getlang("ไอเทมใน::l::item in ")." $havecount ".getlang("รายการ::l::record") ;
}

$dsp[3][text]="Title";
$dsp[3][field]="mid";
$dsp[3][filter]="module:localmdtitle";
$dsp[3][width]="30%";

$dsp[6][text]="จำนวนซ้ำ::l::Duplicates count";
$dsp[6][field]="cc";
$dsp[6][align]="center";
$dsp[6][width]="10%";

/*
$dsp[4][text]="จำนวนไอเทม::l::Item count";
$dsp[4][field]="mid";
$dsp[4][align]="center";
$dsp[4][filter]="module:localcountitem";
$dsp[4][width]="15%";
*/
$dsp[5][text]="รวม::l::Merge";
$dsp[5][field]="mid";
$dsp[5][align]="center";
$dsp[5][filter]="module:localmerge";
$dsp[5][width]="15%";

?><TABLE	width="<?php  echo $_TBWIDTH?>" align=center ID=libmannform>
<FORM METHOD=POST ACTION="index.php">
	<TR>
	<TD align=center> ค้นหาจากชื่อ <INPUT TYPE="text" NAME="searchtitle" value="<?php echo $searchtitle?>"> <INPUT TYPE="submit" value="ค้นหา"> <?php  
	if ($search!="") {
		echo " <A HREF='index.php' class=a_btn>แสดงทั้งหมด</A>";
	}
	?></TD>
</TR>
</FORM>
</TABLE><?php  
if ($searchtitle=="") {
	$limit=" 1 ";

	html_dialog("กรุณาใส่ข้อความสืบค้น"," กรุณาใส่ข้อความสำหรับสืบค้นด้วย เพื่อเป็นการจำกัดจำนวนข้อมูลที่ทำการตรวจสอบ เนื่องจาก การแสดงรายการทั้งหมดอาจใช้เวลาประมวลผลนานเกินไป");
	foot();
	die;
} else {

	$searchtitle=addslashes($searchtitle);
	$limit=" (tag245 like '$searchtitle%' or tag245 like '%$searchtitle%') ";
}

//echo $limit;
fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","mi=$mi",$c,"cc desc",$o,"ID,$grouplist,count(id) as cc","group by $grouplist having cc>1");



foot();
?>