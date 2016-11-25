<?php 
	; 
		
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();
		pagesection(getlang("ประวัติ::l::History"));

$s=tmq("select * from offlinecir where importid='".addslashes($importid)."' ",false);	
?><table cellpadding=0 cellspacing=0 border=0 align=center width=95% class=table_border>
<?php 
while ($r=tfa($s)) {
	$da=explode(":",$r[data]);

?>
<tr>
	<td class=table_td><?php 
echo "type: ".($r[act]);
if ($r[act]=="checkin") {
	echo " Barcode:".$da[1];
}
if ($r[act]=="checkout") {
	echo " Barcode:".$da[2];
	echo " member:".$da[1] ." ".get_member_name($da[1]);
}
?><div style="display:none" id="det<?php  echo $r[id]?>"><?php 
	$dat=unserialize($r[fullres]);	//printr($dat);
	echo "Status:".$dat[status];
	if (floor($dat[media_pid])!=0) {
		echo "<br>Title".marc_gettitle($dat[media_pid]);
	}
	if (floor($dat[memid])!=0) {
		echo "<br>Title".get_member_name($dat[memid]);
	}
	@reset($dat);
	while (list($k,$v)=each($dat)) {
		if (is_array($v) && count($v)>0) {
			echo "<br><b>$k</b>";
			while (list($k2,$v2)=each($v)) {
				echo "<br>&nbsp;&nbsp;".getlang($v2);
			}
		}
	}
?></div></td>
	<td align=right width=200  class=table_td><a href="javascript:void(null);" onclick="tmp=getobj('det<?php  echo $r[id];?>'); tmp.style.display='block'"><?php 
	if ($r[res]=="") {
		$r[res]="---";
	}

	if ($r[res]!="success") {
		$r[res]="<b style='color:darkred;'>".$r[res]."</b>";
	} else {
		$r[res]="<b style='color:darkgreen;'>".$r[res]."</b>";
	}
	echo "Status: ".$r[res];
//echo number_format($r[cc]);
?></a></td>
</tr>
<?php 
}?>
</table>