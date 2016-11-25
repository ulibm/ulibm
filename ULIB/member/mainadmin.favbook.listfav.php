<?php 
	include ("../inc/config.inc.php");
if ($_memid=="") {
	die("Pls login");
}

html_start();

if ($incate!="") {
	?><TABLE width=100% cellpadding=0 cellspacing=0 class=table_border>
	<TR>
		<TD class=table_td><?php 
	$sincate=tmq("select * from webpage_memfavbook_perscate where id='$incate' and memid='$_memid' ",false);
	$sincate=tmq_fetch_array($sincate);
	echo getlang("ในหัวข้อ::l::In folder");
	echo " <IMG SRC='./miscimg/folder.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT='' align=absmiddle> ".getlang($sincate[name]);
	?> &nbsp; :: &nbsp; <A HREF="mainadmin.favbook.listfav.php"><?php 
		echo getlang("แสดงทุกหัวข้อ::l::Display from all folders");?></A></TD>
	</TR>
	</TABLE><?php 
}
$submitbtn=trim($submitbtn);
if (!empty($selectedfav) && count($selectedfav)>0 && is_array($selectedfav)){ 
		@reset($selectedfav);
	while (list($k,$v)=each($selectedfav)) {
			if ($movedocument!="none" && ($submitbtn=="ย้าย" || $submitbtn=="Move")) {
				$chk=tmq("select * from webpage_memfavbook_perscate where id='$movedocument' and memid='$_memid' ");
				if (tmq_num_rows($chk)!=0) {
					$s="update webpage_memfavbook set perscate='$movedocument' where id='$v' and memid='$_memid' ";
					//echo $s;
					tmq($s,false);
				}
			} else{
				if  ($submitbtn=="ลบ" || $submitbtn=="Remove") { 
					$s="delete from webpage_memfavbook where id='$v' and memid='$_memid' ";
					//echo $s;
					tmq($s,false);
				} 
			}
	}
}


$tbname="webpage_memfavbook";


$c[2][text]="Perscate::l::Perscate";
$c[2][field]="perscate";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Dt::l::Dt";
$c[3][field]="dt";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Bibid::l::Bibid";
$c[4][field]="bibid";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Memid::l::Memid";
$c[5][field]="memid";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="";

//dsp


$dsp[4][text]="-";
$dsp[4][field]="perscate";
$dsp[4][filter]="module:local_checkbox";
$dsp[4][width]="5%";

$dsp[2][text]="รายการโปรด::l::Favourite List";
$dsp[2][field]="perscate";
$dsp[2][filter]="module:local_dsp";
$dsp[2][width]="70%";


$perscatedb=tmq_dump2("webpage_memfavbook_perscate","id","name","",""," memid='$_memid' ");

function local_checkbox($wh) {
	$s="<INPUT TYPE=checkbox NAME='selectedfav[]' value='$wh[id]' style='border:0'>";
	return $s;
}

function local_dsp($wh) {
	global $perscatedb;
	$s="<FONT class=smaller><A HREF='../dublin.php?ID=$wh[bibid]' target=_blank class=smaller>";
	$s.=marc_gettitle($wh[bibid])."</A><BR>&nbsp;&nbsp;&nbsp;	".getlang("เพิ่มเมื่อ::l::Added")." ".ymd_datestr($wh[dt])."";


	$itdstr="";
	if (barcodeval_get("webpage-o-upachideitem")=="yes") {
	} else {
		$itd=tmq("select * from media_mid where pid='$wh[bibid]' ");
		$itdok=0;
		$itdcheckedout=0;
		while ($itdr=tmq_fetch_array($itd)) {
					$itdchk=tmq("select id from checkout where mediaId='$itdr[bcode]' and allow='yes' and returned='no' ");
					if (tmq_num_rows($itdchk)==0) {
							$itdok++;
					} else {
							$itdcheckedout++;
					}
		}
		if (($itdok+$itdcheckedout)==0) {
			 $itdstr="ไม่มีไอเทมให้บริการ";
		} else {
			if ($itdok==0 && $itdcheckedout!=0) {
			 $itdstr="ทุกไอเทมถูกยืมอยู่ ($itdcheckedout ไอเทม)"; 
			}
			if ($itdok!=0 && $itdcheckedout==0) {
			 $itdstr="ทุกไอเทมพร้อมให้บริการ (มี $itdok ไอเทม)"; 
			}
			if ($itdok!=0 && $itdcheckedout!=0) {
			 $itdstr="มี $itdok พร้อมให้บริการ และ $itdcheckedout ไอเทมถูกยืม (มี ".($itdok+$itdcheckedout)." ไอเทม)"; 
			}
		}
		$itdstr=trim($itdstr);
		if ($itdstr!="") {
			 $s.= "<BR>&nbsp;&nbsp;&nbsp;<font style='font-size: 12px; color: #333333;'><img src='../neoimg/Warning.gif' align=absmiddle border=0> $itdstr</font>";
		}
	}

	if ($wh[perscate]!=0) {
		 $s.= "<BR>&nbsp;&nbsp;&nbsp;<font style='font-size: 12px; color: #333333;'><img src='./miscimg/folder.png' align=absmiddle border=0 width=12 height=12> ".getlang("ในหัวข้อ::l::Folder")." ".$perscatedb[$wh[perscate]]."</font>";
	}
	echo "
	
	</FONT>";


	return $s;
}

$o[tablewidth]="100%";
$limit="";
if ($incate!="") {
	//$o[addlink][]="mainadmin.favbook.listfav.php::".getlang("แสดงทุกหัวข้อ::l::Display from all folders");
	$limit=" and perscate='$incate' ";
}
?><TABLE width=100% cellpadding=0 cellspacing=0>
<FORM METHOD=POST ACTION="mainadmin.favbook.listfav.php" name="favbookform">
<INPUT TYPE="hidden" NAME="incate" value="<?php  echo $incate;?>">
	<TR>
	<TD><?php 
fixform_tablelister($tbname," memid='$_memid' $limit ",$dsp,"no","no","yes","incate=$incate",$c,"dt desc",$o);
?></TD>
</TR>
<TR>
	<TD>
	
<INPUT TYPE="button" onclick="local_all(document.forms['favbookform']['selectedfav[]'])" value="<?php  echo getlang("เลือก::l::Select");?>"> &nbsp;
	<INPUT TYPE="submit" onclick="return confirm('Confirm Remove');" value=" <?php  echo getlang("ลบ::l::Remove");?> " name="submitbtn" style="color: darkred; font-weight: bold">
	&nbsp; 

<?php  echo  getlang("ย้าย::l::Move")?>:
<SELECT NAME="movedocument">
	<OPTION VALUE="none" SELECTED><?php 
	echo getlang("ย้ายไปยัง::l::Move selected to");?>
<?php 
function localfoldertree($wh,$c) {
	global $_memid;
	$ss=tmq("select * from webpage_memfavbook_perscate where nested='$wh' and memid='$_memid' ");
	while ($r=tmq_fetch_array($ss)) {
		echo "<OPTION VALUE='$r[id]' >+";
		for ($i=1;$i<=$c;$i++) { 
			echo ' - '; 
		}
		echo getlang($r[name]);
		$c2=$c+1;
		localfoldertree($r[id],$c2);
	}
}

localfoldertree(-1,0);

?>
</SELECT>
	<INPUT TYPE="submit" value="<?php  echo getlang("ย้าย::l::Move");?>" name="submitbtn" style="color: darkblue">

	</TD>
</TR>
</FORM>
<SCRIPT LANGUAGE="JavaScript">
<!--
local_all_all=false;
function local_all(wh) {
//alert(wh);
	//x=document.forms["searchform"].getElementsByTagName("input");
		if (local_all_all==true)
		{
			local_all_all=false;
		} else {
			local_all_all=true;
		}
for (i = 0; i < wh.length; i++) {
		if (local_all_all==true)
		{
			wh[i].checked=local_all_all;
		} else {
			wh[i].checked=local_all_all;
		}
}
wh.checked=local_all_all
}

function local_swapitem(wh) {
	x=getobj(wh);
	if (x.checked==false) {
		x.checked=true;
	} else {
		x.checked=false;
	}
}
//-->
</SCRIPT>
</TABLE><?php 
?>