<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
include("inc.php");


$tbname="media_place_shelf";

$c[2][text]="ชื่อตู้เก็บ::l::Shelf name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]=getlang("รายชื่อตู้จะเรียงตามชื่อตู้::l::Shelves order by shelf name");
$c[2][defval]="";

$c[3][text]="เริ่มจากเลขเรียก::l::Start call number";
$c[3][field]="startc";
$c[3][fieldtype]="callnpicker";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="เลขเรียกสุดท้าย::l::Last call number";
$c[4][field]="endc";
$c[4][fieldtype]="callnpicker";
$c[4][descr]="";
$c[4][defval]="";

$c[8][text]="ตำแหน่งในแผนที่::l::Place on map";
$c[8][field]="mappos2";
$c[8][fieldtype]="mappos2,$id";
$c[8][descr]="";
$c[8][defval]="";

$c[5][text]="ประเภทวัสดุ::l::Media type";
$c[5][field]="mdtype";
$c[5][fieldtype]="frm_restype";
$c[5][descr]="";
$c[5][defval]="";

$c[6][text]="ประเภทเลขเรียก::l::Call number type";
$c[6][field]="callntype";
$c[6][fieldtype]="list:DC,LS,None";
$c[6][descr]="";
$c[6][defval]="None";

$c[7][text]=" ";
$c[7][field]="pid";
$c[7][fieldtype]="addcontrol";
$c[7][descr]="";
$c[7][defval]="$id";


//printr($selectlist);
//dsp
$dsp[2][text]="สาขาห้องสมุด/สถานที่ - ตู้::l::Library campus/Place - Shelf";
$dsp[2][field]="id";
$dsp[2][width]="30%";
$dsp[2][filter]="module:local_libsite";

$dsp[3][text]="เลขเรียก::l::Call number";
$dsp[3][field]="id";
$dsp[3][width]="30%";
$dsp[3][filter]="module:local_calln";

$dsp[4][text]="คำสั่ง::l::Action";
$dsp[4][field]="id";
$dsp[4][align]="center";
$dsp[4][width]="15%";
$dsp[4][filter]="module:local_action";

function local_libsite($wh) {
	global $id;
		$tmpshf=tmq("select * from media_place where code='$id' ");
		$tmpshf=tmq_fetch_array($tmpshf);
		$tmpshf=$tmpshf[main];
	$s="<B>".get_libsite_name($tmpshf)." </B>/ ";
	$s.="<BR>" . get_itemplace_name($wh[pid])." - <U><B>$wh[name]</B></U>";
	return $s;
}

function local_calln($wh) {
	global $id;
	$s="$wh[startc] - $wh[endc]<BR>
	<I>".local_callndescr($wh[startc],$wh[callntype])." - " . local_callndescr($wh[endc],$wh[callntype])."</I>";
	return $s;
}
function local_action($wh) {
	global $id;
	$s="<A HREF='pdf.php?shfid=$wh[id]' class='a_btn' target=_blank>".getlang("พิมพ์ใบปะตู้::l::Print shelf note")."</A>";
	return $s;
}


fixform_tablelister($tbname," pid='$id' ",$dsp,"yes","yes","yes","id=$id",$c,"name");
?><CENTER><B>

<A HREF="index.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></A> :: 
<A HREF="manpos.php?id=<?php  echo $id;?>" class=a_btn><?php  echo getlang("จัดการตำแหน่งชั้นวาง::l::Manage shelves position");?></A>
</B></CENTER><?php 
foot();
?>