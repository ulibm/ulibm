<?php 
include("../inc/config.inc.php");
	if ($_memid=="") {
		redir( $dcrURL."/member/index.php?backto=".urlencode($dcrURL."OSS")); die;
	} 
html_start();
head();
include("localhead.php");

pagesection("ส่งคำขอรายการใหม่::l::New Request");
$now=time();
if ($issave=="yes") {
	echo "Saving..";
	$idcard=$_memid;
	sessionval_set("email",$email);
	sessionval_set("servicetype",$servicetype);
	sessionval_set("pickupat",$pickupat);
	if ($sources=="") {
		$sources=$sourceother;
	}
	sessionval_set("sources",$sources);
	$cardid=addslashes($cardid);
	$email=addslashes($email);
	$servicetypeoptions=addslashes($email);
	$resptype=addslashes($resptype);
	$bknote=addslashes($bknote);
	$mat_info=addslashes("Title:$bktitl<br>
Author:$bkauth<br>
Detail:$bkdet");
	tmq("insert into oss_req set
	dt='$now',
	cardid='$idcard',
	pickupat='$pickupat',
	servicetypeoptions='$servicetypeoptionsval',
	mat_id='$mat_id',
	bknote='$bknote',
	resptype='$resptype',
	mat_info='$mat_info',
	servicetype='$servicetype',
	sources='$sources'
	",false);

	sessionval_set("landingdata"," ");
	redir("myrequest.php");
	//redir("index.php");
	die;
}

$tbname="library_site";

$landingdata=sessionval_get("landingdata");
$x=unserialize($landingdata);
//printr($x);
$mat_id=$x[bibid];
?>
<script type="text/javascript">
<!--
	function chk(frm) {
		tmp=getobj("bktitl");
		if (tmp.value=="") {
			alert("Please enter title / กรุณาระบุชื่อเรื่อง");
			return false
		}
		tmp=getobj("sourcesotherID");
		tmpt=getobj("sourceother");
		if  (tmp.checked==true && tmpt.value=="") {
			alert("Please enter source of  material  / กรุณาระบุแหล่งสารสนเทศ");
			return false;
		}

		return true;
	}
//-->
</script>
<form method="post" action="new.php" onsubmit="return chk(this);">
<input type="hidden" name="issave" value="yes">
<input type="hidden" name="servicetypeoptionsval" value="" ID=servicetypeoptionsval>
<input type="hidden" name="mat_id" value="<?php  echo $mat_id;?>">
	<table width="<?php  echo $_TBWIDTH-200;?>" align=center cellspacing=0 cellpadding=0>
<tr >
	<td colspan=2 align=center><font size="" color="" class=smaller> <?php // echo getlang("หากคุณต้องการกลับมาดูประวัติการทำรายการย้อนหลัง คุณจะต้องกรอกอีเมล์และรหัสบัตรประจำตัวประชาชน::l::Please type your ID Card No. to view your request history");?></font>	</td>
</tr>

<tr>
	<td align=center class=table_td style="text-align:left!important; width:379px"><?php  //echo getlang("ชื่อเรื่อง/ชื่อหนังสือ::l::Title");?> Request number / หมายเลขคำขอ</td>
	<td ><b> &nbsp; <?php 
	$tcc=tmq("select id from oss_req order by id desc");
	$tcc=tmq_fetch_array($tcc);
	echo ($tcc[id]+1);
	?></b></td>
</tr>
<tr>
	<td align=center class=table_td style="text-align:left!important; width:379px"><?php  //echo getlang("ชื่อเรื่อง/ชื่อหนังสือ::l::Title");?> Title / ชื่อเรื่อง</td>
	<td ><input type="text" name="bktitl" ID="bktitl"  size=40 value="<?php  echo $x[tag245]?>"></td>
</tr>
<tr>
	<td align=center class=table_td style="text-align:left!important;"><?php  //echo getlang("ชื่อผู้แต่ง::l::Author");?>Author /  ชื่อผู้แต่ง</td>
	<td ><input type="text" name="bkauth" size=40 value="<?php  echo $x[tag100]?>"></td>
</tr>
<tr>
	<td align=center class=table_td style="text-align:left!important;"><?php  //echo getlang("รายละเอียด::l::Details");?>Details /  รายละเอียด</td>
	<td ><input type="text" name="bkdet" size=40  value="<?php  
	$tmpdet="$x[tag082],$x[tag260],$x[tag344]";
	$tmpdet=trim($tmpdet,",");
	$tmpdet=str_replace(",,",",",$tmpdet);
	echo $tmpdet?>"></td>
</tr>

<tr>
	<td align=center class=table_td style="text-align:left!important;"><?php  //echo getlang("เป็นทรัพยากรสารสนเทศของที่ใด?::l::Sources");?>Sources / เป็นทรัพยากรสารสนเทศของที่ใด </td>
	<td ><?php 
	if ($mat_id=="") {
		//frm_genlist("sources","select * from oss_sources where 1 order by ordr","classid","name","","no",sessionval_get("sources"));
		$sou=tmq("select * from oss_sources where 1 order by ordr");
		$soui=0;
		while ($sour=tmq_fetch_array($sou)) {
			$soui++;
			?><label><input type="radio" name="sources" value="<?php  echo $sour[name];?>" 
			<?php  if ($soui==1) { echo "checked";}?>
			> <?php  echo $sour[name];?></label><br><?php 
		}
		?><label><input type="radio" name="sources" value="" ID="sourcesotherID"> <?php  echo getlang("อื่น ๆ ::l::Other ");;?></label> <input type="text" name="sourceother" placeholder="" ID="sourceother"><?php 
	}	else {
			echo "";
					?><font style="font-size:14px;" color="#6a6a6a">As appear in WebOPAC / ตามที่ปรากฏใน WebOPAC</font>
					<input type="radio" name="sources" value="" ID="sourcesotherID" style="display:none" >
					<input type="hidden" name="sourceother" ID="sourceother"  value="As appear in WebOPAC::l::ตามที่ปรากฏใน WebOPAC"><?php 

		}
	?></td>
</tr>
<tr>
	<td align=center class=table_td style="text-align:left!important;"><?php  //echo getlang("ลักษณะข้อมูลที่ต้องการ::l::Service Type");?> Type / ลักษณะข้อมูลที่ต้องการ</td>
	<td ><?php 
	frm_genlist("servicetype","select * from oss_servicetype where 1 order by ordr","classid","name","","no",sessionval_get("servicetype"));
	?>
	<div ID="servicetype_dsp" class=smallerstyle="width:400px;"></div>
	<div ID="servicetype_dspoption" class=smallerstyle="width:400px; display:none">


	</div>
	<script type="text/javascript">
	<!--
		tmp=getobj("servicetype");
		tmp.onchange=function(){ recal_servicetype();}
		function recal_servicetype() {
			tmpoption=getobj("servicetype_dspoption");
			tmpoption.innerHTML="";
			tmp=getobj("servicetype");
			recal_servicetype_sub(0);
			dspobj=getobj("servicetype_dsp");
			<?php 
			$s=tmq("select * from oss_servicetype");
			while ($r=tmq_fetch_array($s)) {
				$r[userdescr]=str_replace($newline,"<br>",$r[userdescr]);
				?>
				if (tmp.value=="<?php  echo $r[classid]?>") {
					dspobj.innerHTML="<?php  echo addslashes(getlang($r[userdescr]));?>"
				}
				<?php 
			}
			?>

				//needplace or email
			<?php 
		   $tmpeml=tmq("select * from member where UserAdminID='".$_memid."' ");
		   $tmpeml=tfa($tmpeml);

		   $s=tmq("select * from oss_servicetype where options='yes' ");
			while ($r=tmq_fetch_array($s)) {
				?>
				
				if (tmp.value=="<?php  echo $r[classid]?>") {
					tmpoption.innerHTML='<label><input type="radio" name="servicetypeoptions" value="email" checked onclick="recal_servicetype_sub(0)">	<?php  echo getlang("ส่งทางอีเมล์::l::Send to my E-Mail");?> <font style="color:999999;font-size:11px;cursor:help" TITLE="แก้ไขได้ที่หน้าประวัติส่วนตัว"><?php echo $tmpeml[email]?></font></label>   <br><label><input type="radio" name="servicetypeoptions" value="toplace" onclick="recal_servicetype_sub(1)">	<?php  echo getlang("เป็น CD::l::As CD-ROM");?> </label> ';
				}
				<?php 
			}
			?>
				//always need place
			<?php 
			$s=tmq("select * from oss_servicetype where options<>'yes' ");
			while ($r=tmq_fetch_array($s)) {
				?>
				if (tmp.value=="<?php  echo $r[classid]?>") {
					recal_servicetype_sub(1);
				}
				<?php 
			}
			?>
				//check is self only
			h_pickupat_form=getobj("pickupat_form");
			h_pickuphtml_all=getobj("pickuphtml_all");
			h_pickuphtml_selfonly=getobj("pickuphtml_selfonly");
			h_pickupat_form.innerHTML="";
			<?php 
			$s=tmq("select * from oss_servicetype where 1");
			while ($r=tfa($s)) {
				
				?>
				if (tmp.value=="<?php  echo $r[classid]?>") {
					<?php  if ($r[selfonly]=="yes") {
						?>h_pickupat_form.innerHTML=h_pickuphtml_selfonly.innerHTML;<?php 
					} else {
						?>h_pickupat_form.innerHTML=h_pickuphtml_all.innerHTML;<?php 
					}?>
					
				}
				<?php 
			}
			?>

		}
		function recal_servicetype_sub(cmd) {
				tmpservicesubval=getobj("servicetypeoptionsval");
				tmpservicesubval.value=cmd;
				tmpservicesub=getobj("servicesub");
				tmpservicesub.style.display="none";
				//alert(cmd);
				if (cmd==1) {
					tmpservicesub.style.display="block";
				}
				

		}
	//-->
	</script>
	</td>
</tr>
<tr>
	<td colspan=2><div id="servicesub" class="" style="display:none">
		<table cellspacing=0 cellpadding=0 width=100%>
<tr>
	<td  align=center class=table_td style="text-align:left!important;width:379px"><?php  //echo getlang("รูปแบบการรับเอกสาร::l::Pickup Type");?>  Pickup Location / รูปแบบการรับเอกสาร</td>
	<td >

	<div style="display:none" ID="pickuphtml_all">
	<select name="pickupat" ID="pickupat"><?php 
		$spu=tmq("select * from oss_pickuptype where 1 order by ordr");
		while ($spur=tfa($spu)) { $spur[name]=getlang($spur[name]);
			echo "<option value='$spur[classid]' ";
			if ($spur[classid]==sessionval_get("pickupat")) {
				echo " selected ";
			}
			echo ">$spur[name]";
		}
	?></select></div> 

		<div style="display:none" ID="pickuphtml_selfonly">
	<select name="pickupat" ID="pickupat"><?php 
		$spu=tmq("select * from oss_pickuptype where selfonly='yes' order by ordr");
		while ($spur=tfa($spu)) { $spur[name]=getlang($spur[name]);
			echo "<option value='$spur[classid]' ";
			if ($spur[classid]==sessionval_get("pickupat")) {
				echo " selected ";
			}
			echo ">$spur[name]";
		}
	?></select></div> 
	
	
	<?php 
	?>
	<div ID="pickupat_form"  xstyle="width:400px;"></div>
	<div ID="pickupat_dsp" class=smaller style="width:400px;"></div>
	</td>
</tr>
	</table>
	</div></td>
</tr>
<script type="text/javascript">
	<!--
		tmp=getobj("pickupat");
		tmp.onchange=function(){ recal_pickuptype();}
		function recal_pickuptype() {
			tmp=getobj("pickupat");
			dspobj=getobj("pickupat_dsp");
			<?php 
			$s=tmq("select * from oss_pickuptype");
			while ($r=tmq_fetch_array($s)) {
				$r[userdescr]=str_replace($newline,"<br>",$r[userdescr]);
				?>
				if (tmp.value=="<?php  echo $r[classid]?>") {
					dspobj.innerHTML="<?php  echo addslashes(getlang($r[userdescr]));?>"
				}<?php 
			}
			?>
		}
		recal_pickuptype();

		recal_servicetype_sub(0)
		recal_servicetype();
		//setTimeout("recal_servicetype(); alert(1);",500);

	//-->
	</script>
<tr>
	<td align=center class=table_td style="text-align:left!important;"><?php  //echo getlang("โน๊ตย่อ/ข้อความถึงเจ้าหน้าที่::l::Note");?>  Note / ข้อความถึงเจ้าหน้าที่</td>
	<td ><textarea name="bknote" rows="3" cols="40"></textarea></td>
</tr>
<tr>
	<td align=center class=table_td style="text-align:left!important;">How to response/วิธีการติดต่อกลับที่ต้องการ</td>
	<td >
	<label><input type="radio" name="resptype" value=" This web site/ผ่านระบบศูนย์บริการแบบเบ็ดเสร็จ" selected checked> This web site/ผ่านหน้าเว็บไซต์นี้</label><br>
	<label><input type="radio" name="resptype" value="Email/ทางอีเมล์"> Email/ทางอีเมล์</label><br>
	<label><input type="radio" name="resptype" value="Phone/ทางโทรศัพท์"> Phone/ทางโทรศัพท์</label>
	</td>
</tr>
<tr>
	<td colspan=2 align=center>
<!-- <center style="font-size:12px; color: 777777;"><br></center>
 -->	<br>
	
	<input type="submit" value="<?php  echo getlang("ส่งคำขอ::l::Submit"); ?>" style="font-size:24px; height: 35px;"></td>
</tr>

</table>
</form>
<center>	<a href="index.php" class=a_btn><?php  echo getlang("กลับหน้าหลัก::l::Main Page");?></a>
</center><?php 

//foot();
?>