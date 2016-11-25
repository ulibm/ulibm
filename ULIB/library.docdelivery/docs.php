<?php 
include("../inc/config.inc.php");
include("trap.admin.php");
html_start();


$tbname="docdelivery_docs";

$c[1][text]="ประเภทเอกสาร";
$c[1][field]="type1";
$c[1][fieldtype]="foreign:-localdb-,docdelivery_doctype,id,name";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="เรื่อง";
$c[2][field]="title";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="วันที่สร้างเอกสาร";
$c[3][field]="dt";
$c[3][fieldtype]="datetime";
$c[3][descr]="";
$c[3][defval]=time();

$c[4][text]="ชั้นความเร็ว";
$c[4][field]="speed";
$c[4][fieldtype]="list:ปกติ,ด่วน,ด่วนมาก,ด่วนที่สุด";
$c[4][descr]="";
$c[4][defval]="ปกติ";

$c[5][text]="ชั้นความลับ";
$c[5][field]="secret1";
$c[5][fieldtype]="list:ปกติ,ปกปิด,ลับ,ลับมาก,ลับที่สุด";
$c[5][descr]="";
$c[5][defval]="ปกติ";

$c[6][text]="เลขที่หนังสือ";
$c[6][field]="no";
$c[6][fieldtype]="text";
$c[6][descr]="";
$c[6][defval]="";

$c[7][text]="ลงวันที่";
$c[7][field]="date";
$c[7][fieldtype]="date";
$c[7][descr]="";
$c[7][defval]=time();

$c[8][text]="จาก";
$c[8][field]="from1";
$c[8][fieldtype]="text";
$c[8][descr]="";
$c[8][defval]="";

$c[9][text]="ถึง";
$c[9][field]="to1";
$c[9][fieldtype]="text";
$c[9][descr]="";
$c[9][defval]="";

$c[10][text]="รายละเอียด";
$c[10][field]="detail";
$c[10][fieldtype]="longtext";
$c[10][descr]="";
$c[10][defval]="";

$c[11][text]="การปฏิบัติ";
$c[11][field]="action";
$c[11][fieldtype]="longtext";
$c[11][descr]="";
$c[11][defval]="";

$c[12][text]="หมายเหตุ";
$c[12][field]="note";
$c[12][fieldtype]="longtext";
$c[12][descr]="";
$c[12][defval]="";
$c[12][addon]="globalupload::";

$c[14][text]="loginid";
$c[14][field]="loginid";
$c[14][fieldtype]="addcontrol";
$c[14][descr]="";
$c[14][defval]=$useradminid;

$c[15][text]="ไฟล์";
$c[15][field]="files";
$c[15][fieldtype]="multiplefile";
$c[15][descr]="";
$c[15][defval]="";

$c[16][text]="ผู้รับเอกสาร";
$c[16][field]="readers";
$c[16][fieldtype]="docdelivery_users";
$c[16][descr]="";
$c[16][defval]="";

//dsp


$dsp[1][text]="เอกสาร::l::Documents";
$dsp[1][field]="title";
$dsp[1][filter]="module:local_doc";
$dsp[1][width]="50%";
function local_doc($wh) {
	$res="";
	if (trim($wh[title])=="") {
		$wh[title]="<i>ไม่กำหนดชื่อเรื่อง</i>";
	}
	$res=$res."<a href='read.php?bydocid=$wh[id]' target=_blank>".stripslashes($wh[title])."</a>
	<br>ลงวันที่ ".ymd_datestr($wh[date],"date");;

	return $res;
}


$_TBWIDTH="100%";

$kw=trim($kw);
?><form method="post" action="<?php  echo $PHP_SELF?>">	
<table align=center width=<?php  echo $_TBWIDTH?>>
<tr>
	<td align=center> <?php  echo getlang("ค้นหา::l::Search") ; ?> <input type="text" name="kw" value="<?php  echo $kw;?>"> <input type="submit" value="<?php  echo getlang("ค้นหา::l::Search") ; ?>"></td>
</tr>
</table>
</form>
<?php 
$limit=" 1 ";
if ($kw!="") {
	$kw=addslashes($kw);
	$limit=" 
	title like '%$kw%' or
	no like '%$kw%' or
	from1 like '%$kw%' or
	to1 like '%$kw%' or
	detail like '%$kw%' or
	action like '%$kw%' or
	note like '%$kw%'
	";
}
fixform_tablelister($tbname," $limit ",$dsp,"yes","yes","yes","mi=$mi&limit=$limit",$c,"dt desc",$o,"","");


//printr($_POST);
//printr($ffdat);
//echo "[$ffe_issave]";
//http://rinac.msu.ac.th/web2014/library.docdelivery/docs.php?mi=&limit=%201%20&fftmode=delete&fftdeleteid=3&startrow=0
if ($fftmode=="delete") {
	$sql="delete from docdelivery_readrule where pid='$fftdeleteid'   ";
	tmq($sql,true);
}
if ($ffe_issave=="yes") {
	$usethisid=$fixform_editor_save_newid;
	if (floor($usethisid)==0 && floor($ffteditid)!=0) {
		$usethisid=$ffteditid;
	}
	//echo "[$usethisid]";
	//printr($ftdat);
	//echo $ffdat[readers];
	$valkey=substr($ffdat[readers],10);
	//echo("\$tmpvalval=$$valkey;");
	eval("\$tmpvalval=$$valkey;");
	//printr($tmpvalval);
	@reset($tmpvalval);
	//remove not in these array
	$sql="delete from docdelivery_readrule where pid='$usethisid' and ( 1  ";
	while (list($k,$v)=each($tmpvalval)) {
		$sql=$sql." and loginid<>'$k' ";
	}
	$sql=$sql.")";
	tmq($sql,false);
	$now=time();
	//check exists
	@reset($tmpvalval);
	while (list($k,$v)=each($tmpvalval)) {
		$chk=tmq("select * from docdelivery_readrule where pid='$usethisid' and loginid='$k' ");
		if (tnr($chk)<1) {
			tmq("insert into docdelivery_readrule set pid='$usethisid' , loginid='$k', dt='$now'");
		}
	}
}
?>
<script type="text/javascript">
<!--
	top.scrollTo(0,0);
//-->
</script>