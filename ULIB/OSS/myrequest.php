<?php 
	; 
		
    include ("../inc/config.inc.php");
	$id=$_memid;
	html_start();
head();
$cancel=floor($cancel);
if ($cancel!=0) {
	tmq("delete from oss_req where id=$cancel and cardid='$id'");
}


	$s=tmq("select * from member where UserAdminID='$id' ");
	$s=tfa($s);

include("../library.oss/inc.php");
html_start();
include("localhead.php");
//pagesection(getlang("รายละเอียดของคุณ::l::View your detail"));
pagesection(getlang(barcodeval_get("oss-o-name")));
member_showinfo($_memid);
?>
<?php 

//pagesection(getlang("รายการที่เคยทำรายการ::l::Request history"));



$tbname="oss_req";



//dsp

$dsp[4][text]="วันที่::l::Date";
$dsp[4][field]="dt";
$dsp[4][filter]="module:localdt";
$dsp[4][width]="10%";
function localdt($wh) {
	return ymd_datestr($wh[dt],"datetime");//."<br>".ymd_ago($wh[dt]);
}



$dsp[2][text]="รายการ::l::Information";
$dsp[2][field]="mat_info";
$dsp[2][width]="70%";
$dsp[2][filter]="module:local_mat_info";

function local_mat_info($wh) {
	//printr($wh);
	$whstat=$wh[stat];
	$id=$wh[id];
	$wh=dspmarc($wh[mat_info]);
	$wh="<a href='matdetail.php?id=".$id."' target=_blank>$wh</a> ";
	if ($whstat=="new") {
		$wh.=" <a href='myrequest.php?cancel=$id' onclick=\"return confirm('Please Confirm / กรุณายืนยัน');\" style='color:red;'>ยกเลิก</a>";
	}
	return $wh;
}

$dsp[5][text]="สถานะ::l::Status";
$dsp[5][field]="ordr";
$dsp[5][width]="10%";
$dsp[5][align]="center";
$dsp[5][filter]="module:local_stat";


function local_name($wh) {

	return  get_member_name($wh[idcard]);
}
function local_stat($wh) {
	$s="";
	global $statusdb;//printr($statusdb);
	if ($wh[stat]=="waitpayment") {
		$s.= "<font color=red>";
		$s.= $statusdb[$wh[stat]];
	} elseif ($wh[stat]=="new") {
		$s.= "<img src=new.gif border=0><br><font color=darkgreen>";
		//$s.= $statusdb[$wh[stat]];
	} else {
		$s.= $statusdb[$wh[stat]];
	}
	return "$s";//.$wh[stat];
}


$limit=" cardid='$id' ";
$o[addlink][]='javascript:printthis("'.$id.'")::'.getlang("พิมพ์รายการ::l::Print")."::";
fixform_tablelister($tbname,$limit,$dsp,"no","no","no","id=$id",$c,"id desc",$o);


?><center><a href="index.php" class=a_btn><?php  echo getlang("กลับ::l::Main Page")?></a></center>
<script type="text/javascript">
<!--
	function printthis(id2print) {
		//alert("print.php?puller="+id2print);
		window.open("print.php?puller="+id2print,"printwindow","");
	}
//-->
</script>
<?php foot();?>