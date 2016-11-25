<table cellpadding=0 cellspacing=0 border=0 align=center width=<?php echo $_TBWIDTH;?>>
<tr>
	<td><?php 
function localformat($s) {
	$s=trim($s);
	$s=str_replace("  "," ",$s);
	$s=trim($s," !@#$%^&*()_+=-.,<>");
	return $s;
}
function localformatsql($s) {
	$s=trim($s);
	$s=str_replace("  "," ",$s);
	$s=str_replace("  "," ",$s);
	$s=str_replace(" ","%",$s);
	return $s;
}

html_dialog("Information",getlang("รายการทรัพยากรที่มีข้อมูลใกล้เคียงกับข้อมูลทรัพยากรที่ท่านเคยยืมคืน::l::Similar materials from your checkout history"));

$s=tmq("select distinct pid from checkout_log where hold='".addslashes($_memid)."' order by edt desc limit 100");
$resa=Array();
$resa[au]=Array();
$resa[su]=Array();
while ($r=tfa($s)) {
	//printr($r);
	$tmpkey=trim(marc_getauth($r[pid]));
	$tmpkey=localformat($tmpkey);
	if ($tmpkey!="") {
		$resa[au]["$tmpkey"]=count($resa[au]["$tmpkey"])+1;
	}
	$subjs=tmq("select tag650 as data from media where ID='$r[pid]' ");
	if (tnr($subjs)<1) continue;
	$subjs=tfa($subjs);
	$tmpkeya=explodenewline($subjs[data]);
	$tmpkeya=arr_filter_remnull($tmpkeya);
	//printr($tmpkeya);
	@reset($tmpkeya);
	while (list($k,$v)=each($tmpkeya)) {
		$v=substr($v,2);
		$v=trim(dspmarc($v));
		$v=localformat($v);
		if ($v!="") {
			$resa[su]["$v"]=count($resa[su]["$v"])+1;
		}
	}
}
arsort($resa[su]);
arsort($resa[au]);
@reset($resa);
$indexdb=tmq_dump2("index_ctrl","code","name,fid");
//printr($indexdb);
while (list($k,$v)=each($resa)) {
	//printr($v);
	$maxi=10;
	if ($maxi>count($v)) {
		$maxi=count($v);
	}
	$i=0;
	echo "<br><b>".getlang($indexdb[$k][0])."</b><br>";
	while (list($k2,$v2)=each($v)) {
		$i++;
		if ($i<=$maxi) {
			$str=$k2;
			$cc=tmq("select count(id) as cc from index_db where ".$indexdb[$k][1]." like '%".addslashes(localformatsql($str))."%' and ispublish='yes' ",false);
			$ccc=tfa($cc);
			if (floor($ccc[cc])>0) {
				echo "&nbsp;&nbsp;&nbsp; &quot;$str&quot; ";
				if ($v2>1) {
					echo " ".getlang("ยืมออก $v2 ครั้ง::l::Checkout $v2 times")."";
				}
				echo " <a href='$dcrURL"."searching.php?";
				if ($k=="su") {
					echo "MSUBJECT";
				}
				if ($k=="au") {
					echo "MAUTHOR";
				}
				echo "=".urlencode($str)."' target=_blank>".getlang("มีในฐานข้อมูล::l::View in database")." ";
				echo number_format($ccc[cc]);
				echo "</a><br>";
			}
		}
	}
}
//printr($resa);
?></td>
</tr>
</table>