<?php 
	; 
		
    include ("../inc/config.inc.php");


include("../library.oss/inc.php");
//html_start();
//include("localhead.php");
//pagesection(getlang("รายละเอียดของคุณ::l::View your detail"));



$tbname="oss_req";




function localdt($wh) {
	return ymd_datestr($wh[dt],"datetime");//."<br>".ymd_ago($wh[dt]);
}




function local_mat_info($wh) {
	$wh[mat_info]=str_replace("Title:","Title:<b>",$wh[mat_info]);
	$wh[mat_info]=str_replace("Author:","</b>Author:",$wh[mat_info]);

	$wh=dspmarc($wh[mat_info]);
	return $wh;
}


function local_name($wh) {
	$s=tmq("select * from oss_mem where cardid='$wh[cardid]' ");
	$s=tfa($s);
	return $s[name];
}
function local_stat($wh) {
	$s="";
	global $statusdb;//printr($statusdb);
	if ($wh[stat]=="waitpayment") {
		$s.= "<font color=red>";
		$s.= $statusdb[$wh[stat]];
	} elseif ($wh[stat]=="new") {
		$s.= "<font color=darkgreen>";
		$s.= $statusdb[$wh[stat]];
	} else {
		$s.= $statusdb[$wh[stat]];
	}
	return "$s";//.$wh[stat];
}
$limit="select * from oss_req where stat='done' ";

if ($servicetype!="") {
	$limit.=" and servicetype='$servicetype' ";
	echo "ประเภทการให้บริการ :";
	$s=tmq("select * from oss_servicetype where classid='$servicetype' ");
	$s=tfa($s);
	echo $s[name]."<br>";
		
}
$kw=trim($kw);
if ($kw!="") {
	$limit.="  and mat_info like '%$kw%'" . " or cardid in (select cardid from oss_mem where name like '%$kw%' or email like '%$kw%' )";
	echo "คำค้น : $kw<br>";

}

$limitdate_yea=floor($limitdate_yea);
$limitdate_mon=floor($limitdate_mon);
$limitdate_dat=floor($limitdate_dat);
//echo $limitdate_yea;
$ds=0;
$de=0;
if ($limitdate_yea>0) {
	$ds=mktime(0, 0, 0, 0, 0, $limitdate_yea);
	$de=mktime(0, 0, 0, 0, 0, $limitdate_yea+1);
	echo "ปี ".($limitdate_yea+543);

	if ($limitdate_mon>0) {
		$ds=mktime(0, 0, 0,$limitdate_mon, 0,  $limitdate_yea);
		$de=mktime(0, 0, 0, $limitdate_mon+1,0,  $limitdate_yea);
		echo " เดือน ".$thaimonstr[$limitdate_mon];
		if ($limitdate_dat>0) {
			$ds=mktime(0, 0, 0, $limitdate_mon,$limitdate_dat,  $limitdate_yea);
			$de=mktime(0, 0, 0,  $limitdate_mon,$limitdate_dat+1, $limitdate_yea);
			echo " วันที่ $limitdate_dat";
		}
	}
}
if ($de>0 && $de>0) {
	$limit.=" and (dt>=$ds and dt<=$de) ";
	//echo "$limitdate_yea/$limitdate_mon/$limitdate_dat<br>";
	//echo ymd_datestr($ds)."-".ymd_datestr($de);
}


$s=tmq("$limit order by id desc ");
?><table width=100% border=1>
<?php 
while ($r=tmq_fetch_array($s)) {
	?>
<tr>
	<td><?php echo ($r[id]);?></td>
	<td width=150><?php echo localdt($r);?></td>
	<td><?php echo local_mat_info($r);?></td>
	<td width=150><?php 
	$ss=tmq("select * from oss_mem where cardid='$r[cardid]' ");
	$ss=tfa($ss);
	echo $ss[name]."<br>";
	echo $ss[email];
	?></td>
	<!-- <td align=center><?php echo local_stat($r);?></td> -->
</tr><?php 
}
?>
</table><?php 
//$limit=" cardid='$id' ";
//$o[addlink][]='javascript:printthis("'.$id.'")::'.getlang("พิมพ์รายการ::l::Print")."::_blank";
//fixform_tablelister($tbname,$limit,$dsp,"no","no","no","id=$id",$c,"id desc",$o);


?>

<script language="javascript" type="text/javascript">
 // window.print();
  window.onfocus = function () {
 //    window.close();
  }
</script>