<?php 
include("../inc/config.inc.php");
html_start();


$tbname="docdelivery_readrule";

$dsp[1][text]="เอกสาร::l::Documents";
$dsp[1][field]="title";
$dsp[1][filter]="module:local_doc";
$dsp[1][width]="50%";
function local_doc($wh) {
	$idorig=$wh[id];
	$isreadedorig=$wh[readed];
	$wh=tmq("select * from docdelivery_docs where id='$wh[pid]' ",false);
	$wh=tfa($wh);
	$res="";
	if (trim($wh[title])=="") {
		$wh[title]="<i>ไม่กำหนดชื่อเรื่อง</i>";
	}
	$res=$res."<a href='read.php?byreadruleid=$idorig' target=_blank>".stripslashes($wh[title])."</a> ";

	if ($isreadedorig=="yes") {
		$res.= "<b style='color: darkgreen; font-weight: bold;'>อ่านแล้ว</b>";
	} else {
		$res.= "<b style='color: darkred; font-weight: bold;'>ยังไม่อ่าน</b>";
	}
	$res.="<br>ลงวันที่ ".ymd_datestr($wh[date],"date");;

	return $res;
}


$_TBWIDTH="100%";

$kw=trim($kw);
?><form method="post" action="<?php  echo $PHP_SELF?>">	
<input type="hidden" name="viewbin" value="<?php  echo $viewbin;?>">
<input type="hidden" name="tags" value="<?php  echo $tags;?>">
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
	$limit=" 1 and pid in (
	select id from docdelivery_docs where
	title like '%$kw%' or
	no like '%$kw%' or
	from1 like '%$kw%' or
	to1 like '%$kw%' or
	detail like '%$kw%' or
	action like '%$kw%' or
	note like '%$kw%'
		)
	";
}
$limit=" ($limit)  and loginid='$useradminid' ";
//echo $limit;
if ($viewbin=="yes") {
	$limit.=" and deleted='yes' ";
} else {
	$limit.=" and deleted='no' ";
}
if ($tags!="") {
	$limit.=" and tags like '%".addslashes($tags)."%' ";
}
fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","mi=$mi&viewbin=$viewbin&tags=$tags&limit=$limit",$c,"dt desc",$o,"","");


?>