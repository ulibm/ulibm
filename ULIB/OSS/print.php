<?php 
	; 
		
    include ("../inc/config.inc.php");
	$id=$_memid;
	$s=tmq("select * from member where UserAdminID='$id'  order by id desc");
	$s=tfa($s);
	//html_start();
	//head();

include("../library.oss/inc.php");
//html_start();
//include("localhead.php");
//pagesection(getlang("รายละเอียดของคุณ::l::View your detail"));
$member_showlonginfo_isshowexternallinks="no";
member_showlonginfo($_memid);


//pagesection(getlang("รายการที่เคยทำรายการ::l::Request history"));



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

$s=tmq("select * from $tbname where cardid='$id' order by id desc ");
?><table width=100% border=1>
<?php 
while ($r=tmq_fetch_array($s)) {
	?>
<tr>
	<td><?php echo ($r[id]);?></td>
	<td width=150><?php echo localdt($r);?></td>
	<td><?php echo local_mat_info($r);?></td>
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
  window.print();
  window.onfocus = function () {
     window.close();
  }
</script>