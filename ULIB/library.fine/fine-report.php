<?php 
    ;
	include("../inc/config.inc.php");

	$limitstr="";
	$limit=" 1 and  (dt>=$dts and dt<=".($dte+(60*60*24)).") ";
if ($membertype!="") {
	$limitstr.= getlang("ประเภทสมาชิก::l::Member type");
	$limitstr.= " ";
	$inf=tmq("select * from member_type where type='$membertype' ");
	$inf=tfa($inf);
	$limitstr.= getlang($inf[descr]) ." ";
	$limit.=" and member in (select UserAdminID from member where type='$membertype' ) ";
}
if ($library!="") {
	$limitstr.= getlang("เจ้าหน้าที่ห้องสมุด::l::By Librarian");
	$limitstr.= " ";
	$limitstr.= get_library_name($library) ." ";
	$limit.=" and lib='$library'  ";
}
if ($libsite!="") {
	$limitstr.= getlang("สาขาของเจ้าหน้าที่ห้องสมุด::l::By Campus of Librarian");
	$limitstr.= " ";
	$limitstr.= get_libsite_name($libsite) ." ";
	$limit.=" and lib in  (select UserAdminID from library where libsite='$libsite' ) ";
}
if ($room!="") {
	$limitstr.= getlang("$_ROOMWORD");
	$limitstr.= " ";
	$inf=tmq("select * from room where id='$room' ");
	$inf=tfa($inf);
	//$limitstr.= getlang($inf[name]) ." ";
	$limitstr.= get_room_name($room) ." ";
	$limit.=" and member in  (select UserAdminID from member where room='$room' ) ";
}
if ($major!="") {
	$limitstr.= getlang("$_FACULTYWORD");
	$limitstr.= " ";
	$inf=tmq("select * from major where id='$major' ");
	$inf=tfa($inf);
	$limitstr.= getlang($inf[name]) ." ";
	$limit.=" and member in  (select UserAdminID from member where major='$major' ) ";
}

if ($export=="yes") {
	header("Content-type: application/ms-download\n\n");
	header("Content-Disposition: attachment; filename=\"export.csv\"\n"); 
	   header("Pragma: no-cache");
   header("Expires: 0");
   echo "\xEF\xBB\xBF"; //UTF-8 BOM
	?>MemberBarcode,MemberName,AllFines,PayCach,PayCredit,RealFine,Note,Librarian,LibrarianID
<?php 
		$s=tmq("select * from finedone where $limit ");
		while ($w=tfa($s)) {
			echo $w[member];
			echo ",".strip_tags(get_member_name($w[member]));
	$list=tmq("select * from fine where isdone='yes' and idid='$w[idid]' ");
	$sum1=0;
	echo ",";
	while ($listr=tfa($list)) {
		$sum1=$sum1+$listr[fine];
		echo "$listr[topic] -".number_format($listr[fine])." ฿ /";
	}
	echo ",".($w[cach]);
	echo ",".($w[credit]);
	echo ",".($sum1);
	echo ",".$w[note] ;
	echo ",".strip_tags(get_library_name($w[lib]));
	echo ",".$w[lib];
	echo "
";
		}
		die;
}

	head();
	include("_REQPERM.php");
	mn_lib();


$tbname="finedone";

//dsp


$dsp[1][text]="รายละเอียด::l::Detail";
$dsp[1][field]="type";
$dsp[1][filter]="module:localdet";
$dsp[1][width]="100%";
function localdet($w) {
	$ret="";
	$ret.="<b>".get_member_name($w[member])."</b><br><font class=smaller>";
	$list=tmq("select * from fine where isdone='yes' and idid='$w[idid]' ");
	$sum1=0;
	while ($listr=tfa($list)) {
		$sum1=$sum1+$listr[fine];
		$ret.=" &nbsp;&nbsp;&bull; $listr[topic] -".number_format($listr[fine])." ฿<br>";
	}
	$ret.=getlang("รวม::l::total")."  <b>".number_format($w[cach])."</b> ฿ <b>".number_format($w[credit])."</b> credit</font >";
	if (floor($sum1)!=floor($w[cach]+$w[credit]) ) {
		$ret.=" <font color=darkred>ยอดจริง ".number_format($sum1)."</font>";
	}
	if (trim($w[note])!="") {
		$ret.=" <br>*note: $w[note] <br>";
	}
	$ret.=" <font class=smaller>".getlang("โดย::l::By")." ".get_library_name($w[lib])."</font>";
	return $ret;
}

?><center><br><?php 
	echo getlang("เริ่มจาก::l::From");
	echo " ";
	echo ymd_datestr($dts,"date");;
	echo " ";
	echo getlang("จนถึง::l::to");
	echo " ";
	echo ymd_datestr($dte,"date");
	echo "<br>";
	echo $limitstr;

?><br></center><?php 



//echo $limit;
fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","dts=$dts&dte=$dte&membertype=$membertype&library=$library&libsite=$libsite&room=$room&php?major=$major",$c,"",$o);
	?><center><a href="<?php  echo $PHP_SELF; ?>?export=yes&<?php  echo "dts=$dts&dte=$dte&membertype=$membertype&library=$library&libsite=$libsite&room=$room&php?major=$major"; ?>" class=a_btn>csv</a></center><?php 
	foot();
?>