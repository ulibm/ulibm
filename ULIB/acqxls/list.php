<?php 
include("./cfg.inc.php");
include("./head.php");
//limitpage_var();
tmq("update acqn_sub set isn=trim(isn);");
tmq("update acqn_sub set isn=replace(isn,'-','');");
  //   head();   
/*
if (library_gotpermission("acqn")) {
} else {
	$permupload="no";
}
*/
	$permupload="yes";

$tbname="acqn";

$c[1][text]="หัวข้อรายการ";
$c[1][field]="name";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[12][text]="ข้อความเพิ่มเติม";
$c[12][field]="descr";
$c[12][fieldtype]="longtext";
$c[12][descr]="";
$c[12][defval]="";


$c[15][text]="แสดงให้ผู้ใช้โหวทหรือไม่";
$c[15][field]="showtovote";
$c[15][fieldtype]="list:yes,no";
$c[15][descr]=" ";
$c[15][defval]="";
/*
$c[16][text]="ปีงบประมาณ";
$c[16][field]="yea";
$c[16][fieldtype]="text";
$c[16][descr]=" ";
$c[16][defval]=date("Y")+543;
*/
//

$dsp[1][text]="ชื่อการเสนอราคาทรัพยากร";
$dsp[1][field]="title";
$dsp[1][filter]="module:localview";
$dsp[1][width]="30%";

$dsp[2][text]=$_s[all][name];
$dsp[2][field]="title";
$dsp[2][filter]="module:localview1";
$dsp[2][width]="5%";

$dsp[3][text]=$_s[suggest][name];
$dsp[3][field]="title";
$dsp[3][filter]="module:localview2";
$dsp[3][width]="5%";

$dsp[4][text]=$_s[ordering][name];
$dsp[4][field]="title";
$dsp[4][filter]="module:localview3";
$dsp[4][width]="5%";

$dsp[5][text]=$_s[reject][name];
$dsp[5][field]="title";
$dsp[5][filter]="module:localview4";
$dsp[5][width]="5%";

$dsp[55][text]=$_s[duplicate][name];
$dsp[55][field]="title";
$dsp[55][filter]="module:localview5";
$dsp[55][width]="5%";

$dsp[56][text]=$_s[bookrecieve][name];
$dsp[56][field]="title";
$dsp[56][filter]="module:localview6";
$dsp[56][width]="5%";

/*
$dsp[2][align]="center";
$dsp[2][text]="จัดการรายการทรัพยากร";
$dsp[2][field]="title";
$dsp[2][filter]="module:local_dspsub";
$dsp[2][width]="15%";
*/

function localview($wh) {
	global $_s;
	$s= "<A HREF='./sub.php?pid=$wh[id]'><B>".stripslashes($wh[name])."</B>  <FONT class=smaller color=black>".stripslashes($wh[descr])."</A> ";
	$s.="";
	return $s;
}
function localview5($wh) {
	global $_s;
	$s= "
	<div class='countbox' style='border-color: ".$_s[duplicate][color].";background-color: ".$_s[duplicate][bg].";'><!-- ".$_s[duplicate][name]."<br> -->".tnr(tmq("select id from acqn_sub where pid ='$wh[id]' and stat='duplicate'"))."</div>
	
";
	return $s;
}
function localview6($wh) {
	global $_s;
	$s= "
	<div class='countbox' style='border-color: ".$_s[bookrecieve][color].";background-color: ".$_s[bookrecieve][bg].";'><!-- ".$_s[bookrecieve][name]."<br> -->".tnr(tmq("select id from acqn_sub where pid ='$wh[id]' and stat='bookrecieve'"))."</div>
	
";
	return $s;
}
function localview4($wh) {
	global $_s;
	$s= "
	<div class='countbox' style='border-color: ".$_s[reject][color].";background-color: ".$_s[reject][bg].";'><!-- ".$_s[reject][name]."<br> -->".tnr(tmq("select id from acqn_sub where pid ='$wh[id]' and stat='reject'"))."</div>
	
";
	return $s;
}
function localview3($wh) {
	global $_s;
	$s= "<div class='countbox' style='border-color: ".$_s[ordering][color].";background-color: ".$_s[ordering][bg].";'><!-- ".$_s[ordering][name]."<br> -->".tnr(tmq("select id from acqn_sub where pid ='$wh[id]' and stat='ordering'"))."</div>";
	return $s;
}
function localview2($wh) {
	global $_s;
	$s= "<div class='countbox' style='border-color: ".$_s[suggest][color].";background-color: ".$_s[suggest][bg].";'><!-- ".$_s[suggest][name]."<br> -->".tnr(tmq("select id from acqn_sub where pid ='$wh[id]' and stat='suggest'"))."</div>";
	return $s;
}

function localview1($wh) {
	global $_s;
	$s="<div class='countbox' style='border-color: ".$_s[all][color].";background-color: ".$_s[all][bg].";'><!-- ".$_s[all][name]."<br> -->".tnr(tmq("select id from acqn_sub where pid ='$wh[id]' "))."</div></div>";
	return $s;
}
function local_dspsub($wh) {
	return "<A HREF='./sub.php?pid=$wh[id]'>จัดการ</A><br>
	"."<A HREF='./voteresult.php?pid=$wh[id]'>ผลการโหวท</A>";
}

$limit=" 1 ";
if ($permupload!="yes") {
	$limit=" showtovote='yes' ";
}
$o[tablewidth]="1000";
fixform_tablelister($tbname," $limit ",$dsp,"$permupload","$permupload","$permupload","mi=$mi",$c,"id desc",$o);

    
?><center><a href="setbudget.php" class=a_btn><?php  echo getlang("ตั้งงบประมาณทั้งหมด::l::Quick set budget");?></a></center>
<style>
.countbox {
	text-align:center;
	display:block;
	width: 100%;
	height: 100%;
	border-width: 1px;
	border-style: solid;
	float:right;
	margin: 2px 2px 2px 2px;
}
</style>
<br>
<?php 
foot();
?>