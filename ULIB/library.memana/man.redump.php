<?php 
	; set_time_limit(0);
		
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();
	pagesection(getlang("ดึงข้อมูลผู้ใช้::l::Re generate data"));

	
if ($issave=="yes") {
	$dts=form_pickdt_get("dts");
	$dte=form_pickdt_get("dte")+(60*60*24);
	tmq("delete from memana");
	barcodeval_set("memana-gendt",time());
	$sql="select * from member where 1 ";
	if ($memroom!="") {
	  $sql=$sql. " and room='$memroom' ";
	}
	if ($memtype!="") {
	  $sql=$sql. " and type='$memtype' ";
	}
	$s=tmq($sql,false);
	while ($r=tfa($s)) {
		
		$checkoutcounts=tmq("select * from checkout_log where hold='$r[UserAdminID]' and edt>$dts and edt<=$dte ");
		$checkoutcount=tnr($checkoutcounts);
		$checkoutperiod=0;
		$mediatype=Array();
		while ($checkoutcountsr=tfa($checkoutcounts)) {
			$tmp=ddx($checkoutcountsr[sdat],$checkoutcountsr[smon],$checkoutcountsr[syea]-543,$checkoutcountsr[edat],$checkoutcountsr[emon],$checkoutcountsr[eyea]-543);
			$checkoutperiod=$checkoutperiod+$tmp;
			$mediatype[$checkoutcountsr[RESOURCE_TYPE]]=floor($mediatype[$checkoutcountsr[RESOURCE_TYPE]])+1;
		}
		$mediatype=serialize($mediatype);
		$finecounts=tmq("select * from fine where memberId='$r[UserAdminID]' and dt>$dts and dt<=$dte ");
		$finecount=tnr($finecounts);
		$fineamount=0;
		while ($finecountsr=tfa($finecounts)) {
			$fineamount=$fineamount+$finecountsr[fine];
		}
		$mscounts=tmq("select * from stathist_ms_member_ms where head='$r[UserAdminID]'  and dt>$dts and dt<=$dte ");
		$mscount=tnr($mscounts);
		$webactivitys=tmq("select * from member_log where memid='$r[UserAdminID]'  and dt>$dts and dt<=$dte ");
		$webactivity=tnr($webactivitys);
		tmq("insert into memana set
		checkoutperiod='$checkoutperiod',
		checkoutcount='$checkoutcount',
		mediatype='$mediatype',
		mscount='$mscount',
		webactivity='$webactivity',
		fineamount='$fineamount',
		finecount='$finecount',
		memid='$r[UserAdminID]',
		major='$r[major]',
		room='$r[room]'
		
		");
	}

}
?>
<table border = 0 cellpadding = 0 width = 100% align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
 <tr valign = "top">
  <td colspan=2><?php  echo getlang("ในการใช้งานจะต้องดึงข้อมูลผู้ใช้และข้อมูลการใช้งานมาเพื่อแสดงเป็นรายงาน::l::In order to use please generate member's data and usage.");?><br><?php  echo getlang("ดึงข้อมูลครั้งสุดท้ายเมื่อ ::l::Last generates ");
  echo ymd_datestr(barcodeval_get("memana-gendt"));
    echo "<font class=smaller> (".ymd_ago(barcodeval_get("memana-gendt")).")</font>";
  ?></td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center>
	  <?php echo getlang("ประเภทสมาชิก::l::Member type");?> 
	  <select name = memtype><?php  
	  echo "<option value=''>".getlang("ไม่กำหนด::l::All");
		$result=tmq("select * from member_type");
		while ($row=tfa($result))
			{
			$sl="";
			if ($fixtype==$row[type]) {$sl="selected";}
			$ID = $row[type];
			$descr=getlang($row[descr]);
			echo "<option value='$ID' $sl>$descr";
			}
	?></select><BR>
	<?php echo $_ROOMWORD; ?> <?php form_room("memroom","","yes");?><BR>
	  <?php ?>
	  <?php  
	  if ($dts==0) {
		$dts=time()-(60*60*24*60);
	  }
	  if ($dte==0) {
		$dte=time();
	  }
	  echo getlang("เริ่มจาก::l::From");
	  form_pickdate("dts",$dts);
	  echo "<br>";
	  echo getlang("จนถึง::l::to");
	  form_pickdate("dte",$dte);
	  
	  ?><br>
	  <input type=submit value=' <?php  echo getlang("เริ่มดึงข้อมูล::l::Start generate"); ?> '></td>
</tr></form>
</table>
<?php 
?>