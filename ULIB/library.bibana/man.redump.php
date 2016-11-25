<?php 
	; 
		set_time_limit(0);
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();
	pagesection(getlang("ดึงข้อมูลทรัพยากร::l::Re generate data"));

	
if ($issave=="yes") {
	$dts=form_pickdt_get("dts");
	$dte=form_pickdt_get("dte")+(60*60*24);
	tmq("delete from bibana");
	barcodeval_set("bibana-gendt",time());
	$sql="select distinct pid from media_mid where 1 ";
	if ($restype!="") {
	  $sql.=" and RESOURCE_TYPE='$restype' ";
	}
	$s=tmq($sql);
	while ($r=tfa($s)) {
		$chk=tmq("select id from bibana where bibid='$r[pid]' ");
		if (tnr($chk)==0) {
			tmq("insert into bibana set bibid='$r[pid]' ",false);
		}

		$checkoutcounts=tmq("select * from checkout_log where pid='$r[pid]' and edt>$dts and edt<=$dte ",false);
		$checkoutcount=tnr($checkoutcounts);
		$checkoutperiod=0;
		$membertype=Array();
		while ($checkoutcountsr=tfa($checkoutcounts)) {
			//printr($checkoutcountsr);
			$tmp=ddx($checkoutcountsr[sdat],$checkoutcountsr[smon],$checkoutcountsr[syea]-543,$checkoutcountsr[edat],$checkoutcountsr[emon],$checkoutcountsr[eyea]-543);
			$checkoutperiod=$checkoutperiod+$tmp;
			$membertypeid=tmq("select type from member where UserAdminID='$checkoutcountsr[hold]' ");
			$membertypeid=tfa($membertypeid);
			$membertypeid=$membertypeid[type];
			$membertype[$membertypeid]=floor($membertype[$membertypeid])+1;
		}
		$membertype=serialize($membertype);

		$usedbook=tmq("select * from stathist_used_shelf_bib where foot='$r[pid]' and dt>$dts and dt<=$dte ");
		$usedbook=tnr($usedbook);

		$webactivitys=tmq("select * from stathist_viewbib_bib_type where head='$r[pid]'  and dt>$dts and dt<=$dte ");
		$webactivity=tnr($webactivitys);

		tmq("update bibana set
		checkoutperiod='$checkoutperiod',
		checkoutcount='$checkoutcount',
		membertype='$membertype',
		usedbook='$usedbook',
		webactivity='$webactivity'
		where bibid='$r[pid]' 
		",false);
	}

}
?>
<table border = 0 cellpadding = 0 width = 100% align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
 <tr valign = "top">
  <td colspan=2><?php  echo getlang("ในการใช้งานจะต้องดึงข้อมูลการใช้งานมาเพื่อแสดงเป็นรายงาน::l::In order to use please generate bib's data and usage.");?><br><?php  echo getlang("ดึงข้อมูลครั้งสุดท้ายเมื่อ ::l::Last generates ");
  echo ymd_datestr(barcodeval_get("bibana-gendt"));
    echo "<font class=smaller> (".ymd_ago(barcodeval_get("bibana-gendt")).")</font>";
  ?></td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center>
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
	  Resource Type <?php  frm_restype("restype",$restype,"YES"); ?>
	  <br>
	  <input type=submit value=' <?php  echo getlang("เริ่มดึงข้อมูล::l::Start generate"); ?> '></td>
</tr></form>
</table>
<?php 
?>