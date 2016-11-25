<?php 
include("./cfg.inc.php");
include("./head.php");
//print_r($_POST);
	$budgetdb=tmq("select * from acqn_budget where 1 ",false);
	$bgdb=Array();
	while ($budgetdbr=tmq_fetch_array($budgetdb)) { 
		$bgdb[$budgetdbr[code]]=getlang($budgetdbr[name]). " ";
	}


//set cahce tmp sayyes
$s=tmq("select id from acqn_sub where pid='$pid' ");
while ($r=tfa($s)) {
	$sayyes=tnr(tmq("select SQL_CACHE id from acqn_voted where data like '%,on-$r[id],%' "));
	$sayno=tnr(tmq("select SQL_CACHE id from acqn_voted where data like '%,off-$r[id],%' "));
	tmq("update acqn_sub set tmpup='$sayyes',tmpdown='$sayno' where id='$r[id]' limit 1 ");
}

	$permupload="yes";
$s=tmq("select SQL_CACHE * from acqn where id='$pid' ");
$s=tfa($s);
?>
<style>
a.chkopaca:visited {
	color: #FF0000!important;
	text-decoration:none;
}
</style>
<table width=800 align=center>
<tr>
	<td align=center style='font-size: 22px;'><?php  echo $s[name];
	if ($bystore!="") {
		echo " &nbsp; <font style='font-size:20px; color: darkred'>(สำนักพิมพ์/ร้านค้า $bystore)</font>";
	}
	if ($bysubj!="") {
		echo "&nbsp; <font style='font-size:20px; color: darkred'>($bysubj)</font>";
	}
	
	?></td>
</tr>
<tr>
	<td align=center ><!-- ตั้งสถานะทั้งหมด:  -->
	<?php /*
	echo "<div ID='$jsid"."reject' class='countbox' style='border-color: ".$_s[reject][color].";background-color: ".$_s[reject][bg].";cursor: hand; cursor: pointer;; float:none; display:inline-block'><a href='subsaver.php?mode=saveall&pid=$pid&stat=reject' target=subsaverif onclick=\"return confirm('ตั้งสถานะ> ".$_s[reject][name]." ทุกรายการ กรุณายืนยัน')\">".$_s[reject][name]."</a></div>";
	echo "<div ID='$jsid"."ordering' class='countbox' style='border-color: ".$_s[ordering][color].";background-color: ".$_s[ordering][bg].";cursor: hand; cursor: pointer;; float:none; display:inline-block'><a href='subsaver.php?mode=saveall&pid=$pid&stat=ordering' target=subsaverif onclick=\"return confirm('ตั้งสถานะ> ".$_s[ordering][name]." ทุกรายการ กรุณายืนยัน')\">".$_s[ordering][name]."</a></div>";
	echo "<div ID='$jsid"."suggest' class='countbox' style='border-color: ".$_s[suggest][color].";background-color: ".$_s[suggest][bg].";cursor: hand; cursor: pointer;; float:none; display:inline-block'><a href='subsaver.php?mode=saveall&pid=$pid&stat=suggest' target=subsaverif onclick=\"return confirm('ตั้งสถานะ> ".$_s[suggest][name]." ทุกรายการ กรุณายืนยัน')\">".$_s[suggest][name]."</a></div>";*/
	?>
	
	
<div align=center
style="display:block; border: 1px solid silver; width:780px;"
> <!--  report div -->	
	<b>รายงาน Excel :
</b>	<?php 
		echo "<a href=\"xls.php?pid=$pid&mode=\" target=_blank>".$_s[all][name]."</a> ".number_format(tnr(tmq("select SQL_CACHE id from acqn_sub where pid='$pid'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=ordering\" target=_blank>".$_s[ordering][name]."</a> ".number_format(tnr(tmq("select SQL_CACHE id from acqn_sub where pid='$pid' and stat='ordering'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=reject\" target=_blank>".$_s[reject][name]."</a> ".number_format(tnr(tmq("select SQL_CACHE id from acqn_sub where pid='$pid' and stat='reject'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=duplicate\" target=_blank>".$_s[duplicate][name]."</a> ".number_format(tnr(tmq("select SQL_CACHE id from acqn_sub where pid='$pid' and stat='duplicate'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=suggest\" target=_blank>".$_s[suggest][name]."</a> ".number_format(tnr(tmq("select SQL_CACHE id from acqn_sub where pid='$pid' and stat='suggest'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=suggest\" target=_blank>มาแล้ว</a> ".number_format(tnr(tmq("select SQL_CACHE id from acqn_sub where pid='$pid' and stat='bookrecieve'")));
	?><br>
<form method="post" target=_blank action="xls.php" style="margin: 0px  0px  0px  0px; display:inline;">
<input type="hidden" name="pid" value="<?php  echo $pid; ?>">
	เลือกตามสำนักพิมพ์ 
	<?php 
	$ps=tmq("select distinct s_store, count(id) as cc from acqn_sub where pid='$pid'  group by s_store order by s_store");
	?><select name="bystore" ID=bystore onchange="selectstorechange(this);">
	<option value="">ไม่กำหนด
	<?php 
	while ($psr=tfa($ps)) {
		if ($psr[s_store]=="") {
			$psr[s_store]="[blank]";
		}
	?>
		<option value="<?php  echo $psr[s_store]?>" rel="yes"><?php  echo $psr[s_store]?> (<?php  echo $psr[cc];?>)
	<?php }?>
	</select>
	
	<input type="submit" value='ส่งออก'>
	<input type="button" value="ดู" onclick="viewbystore(this.form);">
	<input type="button" onclick="previewbystore(this.form);" value='ดูตัวอย่าง'>
	<br><div ID="storesub" style="display:inline;">
	
	</div>
	<script type="text/javascript">
	<!--
function viewbystore(wh) {
	tmp=wh.bystore.options[wh.bystore.selectedIndex].value;
	if (tmp=="") {
		return;
	}
	self.location='sub.php?pid=<?php echo $pid;?>&bystore='+tmp;
}
function viewbybudget(wh) {
	tmp=wh.bybudget.options[wh.bybudget.selectedIndex].value;
	if (tmp=="") {
		return;
	}
	self.location='sub.php?pid=<?php echo $pid;?>&bybudget='+tmp;
}
function previewbystore(wh) {
	tmp=wh.bystore.options[wh.bystore.selectedIndex].value;
	if (tmp=="") {
		return;
	}
	//alert('xls.php?viewonly=yes&pid=<?php echo $pid;?>&bystore='+tmp+"");
	window.open('xls.php?viewonly=yes&pid=<?php echo $pid;?>&bystore='+tmp+"");
}

function selectstorechange(wh) {
	tmp=wh.options[wh.selectedIndex].value;
	if (tmp=="") {
		return;
	}
	tmpobj=getobj("storesub");
	tmpobj.innerHTML="<iframe width=780 frameborder=0 height=42 src='chksubstore.php?pid=<?php  echo $pid;?>&store="+tmp+"' style=\"vertical-align : bottom;;\"></iframe><br>";
}		
function selectbudgetchange(wh) {
	tmp=wh.options[wh.selectedIndex].value;
	if (tmp=="") {
		return;
	}
	tmpobj=getobj("budgetsub");
	tmpobj.innerHTML="<iframe width=780 frameborder=0 height=42 src='chksubbudget.php?pid=<?php  echo $pid;?>&budget="+tmp+"' style=\"vertical-align : bottom;;\"></iframe><br>";
}		
	//-->
	</script>
</form>


<form method="post" target=_blank action="xls.php" style="margin: 0px  0px  0px  0px; display:inline;">
<input type="hidden" name="pid" value="<?php  echo $pid; ?>">
	เลือกตามงบประมาณ
	<?php 
	$ps=tmq("select *, count(id) as cc,sum(pricenet) as ss from acqn_sub where pid='$pid'  group by budget order by budget");
	?><select name="budget" ID=bybudget onchange="selectbudgetchange(this);">
	<option value="">ไม่กำหนด
	<?php 
	$bgdb["[blank]"]="[blank]";
	while ($psr=tfa($ps)) {
		if ($psr[budget]=="") {
			$psr[budget]="[blank]";
		}
	?>
		<option value="<?php  echo $psr[budget]?>" rel="yes"><?php  echo $bgdb[$psr[budget]]?> (<?php  echo $psr[cc];?>)
	<?php }?>
	</select>	<input type="submit" value='ส่งออก'> <input type="button" value="ดู" onclick="viewbybudget(this.form);"><br>

	<div ID="budgetsub" style="display:inline;"></div>
	เลือกตามคณะ
	<?php 
	$ps=tmq("select SQL_CACHE distinct s_subj, count(id) as cc from acqn_sub where pid='$pid'  group by s_subj order by s_subj");
	?><select name="subj" ID=bystore onchange="selectsubjchange(this);">
	<option value="">ไม่กำหนด
	<?php 
	while ($psr=tfa($ps)) {
		if ($psr[s_subj]=="") {
			$psr[s_subj]="[blank]";
		}
	?>
		<option value="<?php  echo $psr[s_subj]?>" rel="yes"><?php  echo $psr[s_subj]?> (<?php  echo $psr[cc];?>)
	<?php }?>
	</select>
	
	<input type="submit" value='ส่งออก'> <input type="button" value="ดู" onclick="viewbysubj(this.form);"><br><div ID="subjsub" style="display:inline;"></div>
	<script type="text/javascript">
	<!--
function viewbysubj(wh) {
	tmp=wh.subj.options[wh.subj.selectedIndex].value;
	if (tmp=="") {
		return;
	}
	self.location='sub.php?pid=<?php echo $pid;?>&bysubj='+tmp;
}

function selectsubjchange(wh) {
	tmp=wh.options[wh.selectedIndex].value;
	if (tmp=="") {
		return;
	}
	tmpobj=getobj("subjsub");
	tmpobj.innerHTML="<iframe width=780 frameborder=0 height=82 src='chksubsubj.php?pid=<?php  echo $pid;?>&subj="+tmp+"' style=\"vertical-align : bottom;;\"></iframe><br>";
}		
	//-->
	</script>
</form>



</div> <!-- / report div -->

<div align=center
style="display:block; border: 1px solid silver; width:780px; margin-top: 5px;"
> <!--  search div -->	
<form method="get" action="sub.php" style="margin: 0px  0px  0px  0px; display:inline;">
<b>ค้นหาด้วยคำ
</b><input type="hidden" name="pid" value="<?php  echo $pid?>">

<input type="text" name="searchkw" value="<?php  echo $searchkw;?>">
<?php 
if ($bystore!="") {
?>
แสดงผลเฉพาะสำนักพิมพ์
<b><input type="text" name="bystore" value="<?php  echo $bystore;?>" size=15></b>
<?php  } ?>
<br>
เฉพาะสถานะ
<select name="limitstat">
	<option value="" >
	<option value="suggest" style="background-color:<?php  echo $_s[suggest][bg]?>;" <?php  if ($limitstat=="suggest") {echo " selected checked ";}?>><?php  echo $_s[suggest][name]?>
	<option value="ordering" style="background-color:<?php  echo $_s[ordering][bg]?>;" <?php  if ($limitstat=="ordering") {echo " selected checked ";}?>><?php  echo $_s[ordering][name]?>
	<option value="reject" style="background-color:<?php  echo $_s[reject][bg]?>;" <?php  if ($limitstat=="reject") {echo " selected checked ";}?>><?php  echo $_s[reject][name]?>
	<option value="duplicate" style="background-color:<?php  echo $_s[duplicate][bg]?>;" <?php  if ($limitstat=="duplicate") {echo " selected checked ";}?>><?php  echo $_s[duplicate][name]?>
	<option value="bookrecieve" style="background-color:<?php  echo $_s[bookrecieve][bg]?>;" <?php  if ($limitstat=="bookrecieve") {echo " selected checked ";}?>><?php  echo $_s[bookrecieve][name]?>
</select>

	<input type="submit" value="ค้นหา">
</form>

</div> <!-- / search div -->

</td>
</tr>
</table><?php 


$tbname="acqn_sub";
$ffe_conditionuse=stripslashes($ffe_condition);
$ffteditiduse=stripslashes($ffteditid);

if ($fftmode=="edit") {
	$_TMPACQSUGGESTORNAME=tmq("select * from acqn_sub where id='$ffteditiduse' ");
	$_TMPACQSUGGESTORNAME=tfa($_TMPACQSUGGESTORNAME);
}
if ($ffe_issave=="yes") {
	//print_r($_POST);
	$clog=tmq("select * from acqn_sub where $ffe_conditionuse");
	$clog=tfa($clog);
	if ($clog["stat"]!=$ffdat["stat"] ) {
		//echo $clog["stat"]."!=".$ffdat["stat"];
		$now=time();
		tmq("insert into acqn_sub_clog set sub".trim($ffe_conditionuse).",stat='".$ffdat["stat"]."',dt='$now' ");
	}
}

$c[1][text]="ชื่อเรื่อง";
$c[1][field]="titl";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";
$c[1][addon]="acqdupchecker";

$c[2][text]="-";
$c[2][field]="pid";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$pid;

$c[3][text]="ผู้แต่ง";
$c[3][field]="auth";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ISBN";
$c[4][field]="isn";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[10][text]="สำนักพิมพ์/บริษัท::l::Company";
$c[10][field]="pub";
$c[10][fieldtype]="text"; //"foreign:-localdb-,acqn_company,name,name";
$c[10][descr]="";
$c[10][defval]="";

$c[11][text]="ครั้งที่พิมพ์ / ปีพิมพ์";
$c[11][field]="yea";
$c[11][fieldtype]="text";
$c[11][descr]="";
$c[11][defval]="";

$c[5][text]="จำนวนสำเนา";
$c[5][field]="copy";
$c[5][fieldtype]="number";
$c[5][descr]="";
$c[5][defval]=1;

$c[6][text]="ราคา";
$c[6][field]="price";
$c[6][fieldtype]="number";
$c[6][descr]="";
$c[6][defval]="";

$c[7][text]="ส่วนลด";
$c[7][field]="pricedis_percent";
$c[7][fieldtype]="number";
$c[7][descr]=" %";
$c[7][defval]=0;

$c[8][text]="ราคาสุทธิ";
$c[8][field]="pricenet";
$c[8][fieldtype]="none";
$c[8][descr]=" ระบบจะคำนวณให้อัตโนมัติ";
$c[8][defval]="";

//
$oldval=tmq("select * from acqn_sub where id='$ffteditiduse' ");
$oldval=tfa($oldval);
$c[14][text]="คณะ";
$c[14][field]="s_subj";
$c[14][fieldtype]="foreign:-localdb-,acqn_faculty,name,name,allowblank";
$c[14][descr]="";
$c[14][defval]="$oldval[s_subj]";

$c[9][text]="สถานะ";
$c[9][field]="stat";
$c[9][fieldtype]="foreign:-localdb-,acqn_stat,code,name";
$c[9][descr]="";
$c[9][defval]="ordering";

$c[15][text]="ชื่อผู้แนะนำ";
$c[15][field]="s_name";
$c[15][fieldtype]="text";
$c[15][descr]="";
$c[15][defval]="";

$c[16][text]="อีเมล์ผู้แนะนำ";
$c[16][field]="s_email";
$c[16][fieldtype]="text";
$c[16][descr]="";
$c[16][defval]="";
$c[16][addon]="emailpuller";


$c[18][text]="เบอร์โทรผู้แนะนำ";
$c[18][field]="s_tel";
$c[18][fieldtype]="text";
$c[18][descr]="";
$c[18][defval]="";

$c[17][text]="สถานะผู้แนะนำ";
$c[17][field]="s_stat";
$c[17][fieldtype]="text";
$c[17][descr]="";
$c[17][defval]="";


if ($ffe_issave=="yes") {
	$ffdat[price]=str_replace(",","",$ffdat[price]);
	$ffdat[price]=str_replace(" ","",$ffdat[price]);
	//echo $ffdat[price];die;
	//echo $ffdat[pricedis_percent];die;
	$dis=$ffdat[pricedis_percent];
	//echo floor($ffdat[pricenet])."-$dis<br>";
	$dis2=($ffdat[pricedis_percent]/100);
	//echo ($ffdat[pricedis]/100)."=$dis2<br>";
	$pricedis=$ffdat[price]*$dis2;
	//echo "$ffdat[price]*$dis2=$pricedis<br>";
	$pricenet=$ffdat[price]-$pricedis;
	//echo "net=$pricenet<br>";
	//copy
	$copy=floor($ffdat[copy]);
	if ($copy==0) {
		?><script type="text/javascript">
		<!--
			alert("ไม่อนุญาต : จำนวนสำเนา (copy) ต้องไม่เป็น 0");
		//-->
		</script><?php 
		$ffe_issave="";
	}
	$finalpricenet=$pricenet*$copy;
	//echo "copy $pricenet*$copy=$finalpricenet<br>";
	$ffdat[pricenet]=$finalpricenet;
	$ffdat[pricedis]=$pricedis;
	
}

$c[23][text]="สำนักพิมพ์ที่จะจัดซื้อ::l::Publisher to buy";
$c[23][field]="s_store";
$c[23][fieldtype]="foreign:-localdb-,acqn_company,name,name";
$c[23][descr]="";
$c[23][defval]="";

$c[22][text]="งบประมาณ::l::Budget";
$c[22][field]="budget";
$c[22][fieldtype]="acqn_budget"; //foreign:-localdb-,acqn_budget,code,name
$c[22][descr]="";
$c[22][defval]="";


//

$dsp[1][text]="รายละเอียดทรัพยากร";
$dsp[1][field]="text";
$dsp[1][filter]="module:local_dsp";
$dsp[1][width]="60%";
if ($permupload=="yes") {
	//$o[addlink][] = "addlong.php?pid=$pid::<B>เพิ่มทีละหลายรายการ</B>::_self";
}
//$o[addlink][] = "list.php::กลับ::_self";

function local_dsp($wh) {
	//print_r($wh);
	global $pid;
	global $bgdb;
	global $dcrURL;
	global $_s;
	$sayyes=tnr(tmq("select SQL_CACHE id from acqn_voted where data like '%,on-$wh[id],%' "));
	$sayno=tnr(tmq("select SQL_CACHE id from acqn_voted where data like '%,off-$wh[id],%' "));
	$wh[titl]=trim($wh[titl]);
	$wh[auth]=trim($wh[auth]);
	$wh[isn]=trim($wh[isn]);
	$s="<div style='clear:both;'></div>


<div style='width: 527px;float:left;; border: dotted green 0px;'>
<div style='width: 50;float:left; text-align:center; color: darkgreen;font-size:16;font-weight: bolder;'>".number_format($sayyes)."</div>
<div style='width: 50;float:left; text-align:center; color: darkred; font-size:16;font-weight: bolder; margin-right: 15; border: 0 black dotted; border-right-width:2; padding-right: 3'>".number_format($sayno)."</div>
<a href=\"javascript:void(null)\" onclick=\"window.open('viewsub.php?id=$wh[id]','viewsub','width=500,height=500');\" style='width:400px;border: solid 0px red; display: inline-block;;'><b>".stripslashes($wh[titl])."</b>
".stripslashes($wh[auth])."
".stripslashes($wh[pub])."
".stripslashes($wh[yea])."</a> 
</div>";

	if ($wh["stat"]!="") {
		$localstat[$wh[stat]]="selected";
	}
	if ($wh[stat]=="bookrecieve") {
		$jsid="div".randid();
		$jsclearall="tmp=getobj('$jsid"."suggest'); tmp.className='countbox'; tmp=getobj('$jsid"."ordering'); tmp.className='countbox'; tmp=getobj('$jsid"."reject'); tmp.className='countbox'; tmp=getobj('$jsid"."duplicate'); tmp.className='countbox';";
		$s.="<div style='clear:both;'></div>
		<div style='float:right'>


		<div ID='$jsid"."suggest' class='countbox".$localstat[bookrecieve]."' style='border-color: ".$_s[bookrecieve][color].";background-color: ".$_s[bookrecieve][bg].";cursor: hand; cursor: pointer;; width:300px!important;;'>".$_s[bookrecieve][name]."</div>


		</div>
		<div style='clear:both;'></div>";
	} else {
		$jsid="div".randid();
		$jsclearall="tmp=getobj('$jsid"."suggest'); tmp.className='countbox'; tmp=getobj('$jsid"."ordering'); tmp.className='countbox'; tmp=getobj('$jsid"."reject'); tmp.className='countbox'; tmp=getobj('$jsid"."duplicate'); tmp.className='countbox';";
		$s.="<div style='clear:both;'></div>
		<div style='float:right'>


		<div ID='$jsid"."suggest' class='countbox".$localstat[suggest]."' style='border-color: ".$_s[suggest][color].";background-color: ".$_s[suggest][bg].";cursor: hand; cursor: pointer;;'><a href='subsaver.php?id=$wh[id]&stat=suggest' onclick=\"$jsclearall; tmp=getobj('$jsid"."suggest');tmp.className='countboxselected'\" target=subsaverif>".$_s[suggest][name]."</a></div>
		<div ID='$jsid"."duplicate' class='countbox".$localstat[duplicate]."' style='border-color: ".$_s[duplicate][color].";background-color: ".$_s[duplicate][bg].";cursor: hand; cursor: pointer;;'><a href='subsaver.php?id=$wh[id]&stat=duplicate' onclick=\"$jsclearall; tmp=getobj('$jsid"."duplicate');tmp.className='countboxselected'\" target=subsaverif>".$_s[duplicate][name]."</a></div>
		<div ID='$jsid"."ordering' class='countbox".$localstat[ordering]."' style='border-color: ".$_s[ordering][color].";background-color: ".$_s[ordering][bg].";cursor: hand; cursor: pointer;;'><a href='subsaver.php?id=$wh[id]&stat=ordering' onclick=\"$jsclearall; tmp=getobj('$jsid"."ordering');tmp.className='countboxselected'\" target=subsaverif>".$_s[ordering][name]."</a></div>
		<div ID='$jsid"."reject' class='countbox".$localstat[reject]."' style='border-color: ".$_s[reject][color].";background-color: ".$_s[reject][bg].";cursor: hand; cursor: pointer;;'><a href='subsaver.php?id=$wh[id]&stat=reject' onclick=\"$jsclearall; tmp=getobj('$jsid"."reject');tmp.className='countboxselected'\" target=subsaverif>".$_s[reject][name]."</a></div>
		<div class='countbox' style='border-color: #D2D2D2;background-color: white; width:80px'>฿".number_format($wh[pricenet],2)."-$wh[copy]</div>

		</div>
		<div style='clear:both;'></div>";
	}
		if ($wh[budget]!="") {
		$s.=" &bull; <font class=smaller>".$bgdb[$wh[budget]]."</font>";
	}

	$wh[isn]=addslashes($wh[isn]);
	if ($wh[isn]!="") {
		$chkdups=tmq("select SQL_CACHE id,stat from acqn_sub where isn='$wh[isn]' and id<>$wh[id] and pid in (select id from acqn) ");
		//echo tnr($chkdup); 
		$chkdupc=tnr($chkdups);
		//echo "[$chkdupc] $wh[id]; ";
		if ($chkdupc!=0) {
			$tmponlynewsugg=0;
			while ($chkdupcr=tfa($chkdups)) {
				if ($chkdupcr[stat]=='suggest') {
					$tmponlynewsugg=$tmponlynewsugg+1;
				}
				//echo "[$wh[isn]]$tmponlynewsugg-$chkdupcr[stat]<br>";
			}
			//echo "<br>";
			$localchkstyle="font-size:10px;color:#666666;text-decoration: line-through;;";
			if ($tmponlynewsugg>1) {
				$localchkstyle="font-size:10px;color:darkred;";
			}
			$s.= " <u><a href=\"sub.php?pid=$pid&searchkw=$wh[isn]&frominlinechkdup=yes\" target=_blank style='$localchkstyle'><img src='alert_icon.png' width='16' height='16' border='0' > ISBN ซ้ำในคำขอ $chkdupc</a></u>";
		}
	}
	if ($wh[titl]!="") {
		$chkdups=tmq("select SQL_CACHE id,stat from acqn_sub where titl like '".addslashes($wh[titl])."%' and id<>$wh[id] and pid in (select id from acqn) ");
		//echo tnr($chkdup); 
		$chkdupc=tnr($chkdups);
		if ($chkdupc!=0) {
			$tmponlynewsugg=0;
			while ($chkdupcr=tfa($chkdups)) {
				if ($chkdupcr[stat]=='suggest') {
					$tmponlynewsugg=$tmponlynewsugg+1;
				}
				//echo "[$wh[titl]]$tmponlynewsugg-$chkdupcr[stat]<br>";
			}
			//echo "<br>";
			$localchkstyle="font-size:10px;color:#666666;text-decoration: line-through;;";
			if ($tmponlynewsugg>1) {
				$localchkstyle="font-size:10px;color:darkred;";
			}
			$s.= " <u><a href=\"sub.php?pid=$pid&searchkw=$wh[titl]\" target=_blank style='$localchkstyle'><img src='alert_icon.png' width='16' height='16' border='0' > ชื่อเรื่อง ซ้ำในคำขอ $chkdupc</a></u>";
		}
	}
	$s.="	<div style='float:right'>";
	if ($wh[titl]!="") {
		$s.= "<u><a href=\"".$dcrURL."advsearching.php?bool%5B%5D=%5B%5BAND%5D%5D&kw%5B%5D=$wh[titl]&searchopt%5B%5D=ti\" target=_blank style='font-size:10px;' class=chkopaca>Title<img src='newwindow.png' width='8' height='8' border='0' ></a></u> ";
	}
	if ($wh[auth]!="") {
		$pos = strpos($wh[auth], ",");
		if ($pos === false) {
			$wh[auth]=str_replace("  "," ",$wh[auth]);
			$wh[auth]=str_replace("  "," ",$wh[auth]);
			$wh[auth]=str_replace("  "," ",$wh[auth]);
			$autha=explode(" ",$wh[auth]);
			//print_r($autha);
			//echo "source=$wh[auth],";
			$lastn=$autha[count($autha)-1];
			//echo "lastn=$lastn,";
			array_pop($autha);
			@reset($autha);
			$newname="$lastn,";
			while (list($k,$v)=each($autha)) {
				$newname=$newname." ".$v;
			}
			$newname=trim($newname);
			//echo "newname=$newname";
			//echo "<br>";
			$wh[auth]=$newname;
		}
		$s.= " <u><a href=\"".$dcrURL."advsearching.php?bool%5B%5D=%5B%5BAND%5D%5D&kw%5B%5D=$wh[auth]&searchopt%5B%5D=au\" target=_blank style='font-size:10px;' class=chkopaca>Author<img src='newwindow.png' width='8' height='8' border='0' ></a></u> ";		
	}
	if ($wh[isn]!="") {
		$s.= "<u><a href=\"".$dcrURL."advsearching.php?bool%5B%5D=%5B%5BAND%5D%5D&kw%5B%5D=$wh[isn]&searchopt%5B%5D=ISBN\" target=_blank style='font-size:10px; ' class=chkopaca>ISBN<img src='newwindow.png' width='8' height='8' border='0' ></a></u>";
	}
	if ($wh[titl]=="") {
		$wh[titl]="<i>ไม่ได้กรอกชื่อเรื่อง</i>";
	}
		$s.="
</div>";
	return $s;
}

if ($orderby=="") {
	$orderby="dt";
}
$orderdb[titl]="titl asc";
$orderdb[auth]="auth asc";
$orderdb[tmpup]="tmpup desc";
$orderdb[tmpdown]="tmpdown desc";
$orderdb[dt]="id asc";

$limit="";
$searchkw=trim($searchkw);
$searchkw=addslashes($searchkw);
if ($searchkw!="") {
	$limit.=" and (
	titl like '%$searchkw%' or
	auth like '%$searchkw%' or
	isn like '$searchkw' or
	s_name like '%$searchkw%' or
	s_email like '%$searchkw%' or
	id = '$searchkw' 
	
	
	)";
}
$bystore=trim($bystore);
$bystore=addslashes($bystore);
if ($bystore!="") {
	$limit.=" and s_store='$bystore' ";
}
$bybudget=trim($bybudget);
$bybudget=addslashes($bybudget);
if ($bybudget!="") {
	$limit.=" and budget='$bybudget' ";
}
$limitstat=trim($limitstat);
$limitstat=addslashes($limitstat);
if ($limitstat!="") {
	$limit.=" and stat='$limitstat' ";
}
$bysubj=trim($bysubj);
$bysubj=addslashes($bysubj);
if ($bysubj!="") {
	$limit.=" and s_subj='$bysubj' ";
}
$bysuggestor=trim($bysuggestor);
$bysuggestor=addslashes($bysuggestor);
if ($bysuggestor!="") {
	$limit.=" and s_name like '%$bysuggestor%' ";
}
//echo $limit;
fixform_tablelister($tbname," pid='$pid' $limit",$dsp,"$permupload","$permupload","$permupload","pid=$pid&orderby=$orderby&searchkw=$searchkw&bystore=$bystore&bysubj=$bysubj&limitstat=$limitstat&subj=$subj",$c,$orderdb[$orderby],$o,"");

    
?>
<center>เรียงตาม:
<a href="sub.php?pid=<?php  echo $pid;?>&orderby=dt">ลำดับการแนะนำ</a>
<a href="sub.php?pid=<?php  echo $pid;?>&orderby=titl">ชื่อเรื่อง</a>
<a href="sub.php?pid=<?php  echo $pid;?>&orderby=auth">ชื่อผู้แต่ง</a>
<a href="sub.php?pid=<?php  echo $pid;?>&orderby=tmpup">คะแนนโหวทให้ซื้อ</a>
<a href="sub.php?pid=<?php  echo $pid;?>&orderby=tmpdown">คะแนนโหวทให้ไม่ซื้อ</a>
<?php 
if ($frominlinechkdup=="yes" && $searchkw!="") {
		$s="select distinct pid from acqn_sub where pid<>$pid 
		and (
	titl like '%$searchkw%' or
	auth like '%$searchkw%' or
	isn like '$searchkw' or
	s_name like '%$searchkw%' or
	s_email like '%$searchkw%' or
	id = '$searchkw' 
	
	)";
	$s=tmq($s);
	if (tnr($s)!=0)  {
		?><br><br><table width=780  align=center class=table_td style="border: orange dotted 2px!important;">
		<tr>
			<td class=table_head> การซ้ำในชุดการสั่งซื้ออื่น ๆ</td>
		</tr>
		<tr>
			<td><?php 
		while ($r=tfa($s)) {
			$sn=tmq("select * from acqn where id='$r[pid]' ");
			if (tnr($sn)==0) {
				continue;
			}
			$sn=tfa($sn);
			echo "<b>".$sn[name]."</b><br>";
			$sl=tmq("select * from acqn_sub where pid='$r[pid]' 
					and (
				titl like '%$searchkw%' or
				auth like '%$searchkw%' or
				isn like '$searchkw' or
				s_name like '%$searchkw%' or
				s_email like '%$searchkw%' or
				id = '$searchkw' 
				
				)");
					while ($rl=tfa($sl)) {
						echo " &nbsp;&nbsp; &bull; <a href='sub.php?pid=$rl[pid]&searchkw=$searchkw' target=_blank>$rl[titl] / $rl[auth] / $rl[isn]</a><br> 
						";
					}

		
		}	
		
		?></td>
		</tr>
		</table><?php 
	}
}
?>
</center>

<style>
.countbox {
	font-size: 12px;
	text-align:center;
	display:block;
	width: 100px;
	border-width: 1px;
	border-style: solid;
	float:right;
	margin: 2px 2px 2px 2px;
}
.countbox>a {
	font-size: 12px;
}
.countboxselected>a {
	font-size: 12px;
}
.countboxselected {
	font-size: 12px;
	text-align:center;
	display:block;
	width: 100px;
	border-width: 1px;
	border-style: solid;
	float:right;
	margin: 2px 2px 2px 2px;
	background-image:url(selected.png);
	background-repeat: no-repeat;
}
</style>

<iframe name=subsaverif style="display:none" src="blank.php?rid=<?php  echo randid();?>"></iframe>

<?php 
foot();
?>