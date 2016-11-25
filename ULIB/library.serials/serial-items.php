<?php 
;
     include("../inc/config.inc.php"); 
	head();
	include("_REQPERM.php");
	mn_lib();


	  $sqlchk="SELECT  ID  FROM media where leader  like '_______s%' and ID='$MID' ";
		$sqlchk=tmq($sqlchk);
		if (tnr($sqlchk)!=1) {
			html_dialog("Error","Bib ID=$MID is not serial");
			foot();
			die;
		}

//chk c-serial for backward compat s
$chk=tmq("select * from media_type where code='c-serial' ");
if (tnr($chk)!=1) {
   tmq("delete from media_type where code='c-serial' ");
   tmq("insert into media_type set code='c-serial',name='วารสารฉบับปัจจุบัน::l::Serial Current Copy',delable='NO' ");
}


//chk c-serial for backward compat e

if ($setmute=="yes") {
	tmq("insert into serial_muteexpect set mid='$MID' ",false);
}
if ($setunmute=="yes") {
	tmq("delete from serial_muteexpect where mid='$MID' ",false);
}

$deleteitem=floor($deleteitem);
if ($deleteitem!=0) {
	tmq("delete from media_mid where pid=$MID and id=$deleteitem");
}
	$rectag=getval("MARC","serial_rectype");
	if ($savenumbering=="yes") {
		tmq("delete from serial_info where mid='$MID'"); 
		tmq("insert into serial_info set mid='$MID' ,
		enum1='$field1',
		marccode='$marccode',
		enum2='$field2',
		enumr2='$field2tp',
		enum3='$field3',
		enumr3='$field3tp' 
		"); 
	}
   if ($issetcurrentissues=="yes") {
      barcodeval_set("SERIAL-SETCURRISSUE-NO-$MID",floor($setcurrentissues))  ;
   }
   //update mediatype for c-serial and serial s
   $curnum=barcodeval_get("SERIAL-SETCURRISSUE-NO-$MID");
   $curnum=floor($curnum);
   tmq("update media_mid set RESOURCE_TYPE='serial' where pid='$MID' and (RESOURCE_TYPE='serial' or RESOURCE_TYPE='c-serial')");
   $cstask=tmq("select * from media_mid where pid='$MID' and (RESOURCE_TYPE='serial') ;");
   //echo "[$curnum]";
   if ($curnum!=0 && tnr($cstask)!=0) {
      $latest=tmq("select * from media_mid where pid='$MID' and RESOURCE_TYPE='serial' and (jchrono_1<>'0' or jchrono_2<>'0' or jchrono_3<>'0') and bcode<>'' order by jchrono_1 desc, jchrono_2 desc, jchrono_3 desc,jenum_1 desc,jenum_2 desc,jenum_3 desc, jenum_4 desc, jenum_5 desc , jenum_6 desc limit $curnum",false);
      while ($latestr=tfa($latest)) {
         tmq("update media_mid set RESOURCE_TYPE='c-serial' where pid='$MID'
         and jenum_1='".addslashes($latestr[jenum_1])."'  
         and jenum_2='".addslashes($latestr[jenum_2])."'  
         and jenum_3='".addslashes($latestr[jenum_3])."'  
         and jenum_4='".addslashes($latestr[jenum_4])."'  
         and jenum_5='".addslashes($latestr[jenum_5])."'  
         and jenum_6='".addslashes($latestr[jenum_6])."'  
         
         ",false);
      }
   }
   //update mediatype for c-serial and serial e
	if ($setrectype!="") {
    $setrectype=tmq("select * from serials_rectype where id='$setrectype' ",false);
    $setrectype=tmq_fetch_array($setrectype);
		$setrectype=$setrectype[namelist];
		$setrectype=explode(',',$setrectype);
		$setrectype=$setrectype[1];
		if ($setrectype!="") {
			 tmq("update media set  $rectag='  ^a$setrectype' where ID='$MID' ");
		} else {
			html_dialog("","Cannot set recieve type [$setrectype]");
		}
	}
	
	 ?>
  <table width="780" align=center border="0" cellspacing="0" cellpadding="0" >
    <tr valign="top"> 
      <td>
         <?php 
				 $str=getlang("กลับหน้าฐานข้อมูลวารสาร::l::Back to Serial database").",seriallist.php?linkfrom=$MID&page=$MIDpage,green";
				 html_xpbtn($str);

pagesection(getlang("กำลังจัดการไอเทมวารสาร::l::Managing Items of Serials"));
?><TABLE width="770" border="0" cellspacing="1" cellpadding="3" align=center>
<TR>
	<TD><?php 
  res_brief_dsp($MID);	
?></TD>
</TR>
</TABLE><?php 
$recs=tmq("select * from media where ID ='$MID' ");
$recs=tmq_fetch_array($recs);

$rectype=$recs[$rectag];
$rectype=dspmarc(substr($rectype,2));
$rectype=trim($rectype);
//echo $rectype;
$rectp=tmq("select * from serials_rectype where namelist like '%,$rectype,%' ",false);
$rectps=tmq_fetch_array($rectp);
?>
<table border="0" cellpadding="0" cellspacing="0" width=780 align=center>

<tr>
<td class=table_head width=25%><?php  echo getlang("รูปแบบการบอกรับ::l::Recieve type");?></td>
<td><form action="serial-items.php" method="post">
<input type="hidden" name="MID" value="<?php  echo $MID?>" />
<input type="hidden" name="MIDpage" value="<?php  echo $MIDpage?>" /><?php 
frm_genlist("setrectype","select * from serials_rectype order by name","id","name","-localdb-","no",$rectps[id]);
?>
<input type="submit" value="Save"  class="a_btn"></td>
</form>
</tr>
<tr>
<td class=table_head width=25%><?php  echo getlang("จำนวนวารสารปัจจุบัน ::l::Current issue for ");?></td>
<td><form action="serial-items.php" method="post">
<input type="hidden" name="MID" value="<?php  echo $MID?>" />
<input type="hidden" name="MIDpage" value="<?php  echo $MIDpage?>" />
<input type="hidden" name="issetcurrentissues" value="yes" />
<?php 
form_quickedit("setcurrentissues",barcodeval_get("SERIAL-SETCURRISSUE-NO-$MID"),"list:0,1,2,3,4,5,6,7,8,9,10");
echo getlang(" ฉบับล่าสุด::l:: issues"); ?> 
<input type="submit" value="Save"  class="a_btn"></td>
</form>
</tr>
<tr>
<form action="serial-items.php" method="post">
<input type="hidden" name="MID" value="<?php  echo $MID?>" />
<input type="hidden" name="savenumbering" value="yes" />
<input type="hidden" name="MIDpage" value="<?php  echo $MIDpage?>" />

<td class=table_head width=25%><?php  echo getlang("รูปแบบเลขลำดับ::l::Numbering Rule");?></td>
<td><?php 
$serialinfo=tmq("select * from serial_info where mid='$MID' ");
if (tmq_num_rows($serialinfo)!=1) {
	tmq("delete from serial_info where mid='$MID' ");
	
	echo getlang("ไม่สามารถดำเนินการต่อได้ ต้องกำหนดรูปแบบหมายเลขฉบับก่อน::l::Could not continue, Must specify numbering rule first.")."<BR>";
	$haltserialinfo="yes";
}
$serialinfo=tmq_fetch_array($serialinfo);
?>
<A HREF="javascript:void(null)" onclick="tmp=getobj('editnumberingdiv'); tmp.style.display='block'" class="a_btn smaller"><?php  echo getlang("แก้ไขรูปแบบหมายเลข::l::Edit numbering rule");?></A>
<div ID="editnumberingdiv" style="<?php 
if ($haltserialinfo=="yes") {
	echo "display:block";
} else {
	echo "display:none";
}
?>"><TABLE width=100% class=table_border>
<TR><SCRIPT LANGUAGE="JavaScript">
<!--
function localfillthis(wh) {
	wha=wh.split('|');
	tmp=getobj("field1"); tmp.value=wha[0];
	tmp=getobj("field2"); tmp.value=wha[1];
	tmp=getobj("field3"); tmp.value=wha[2];
	tmp=getobj("field2tp"); tmp.value=wha[3];
	tmp=getobj("field3tp"); tmp.value=wha[4];
	tmp=getobj("marccode"); tmp.value=wha[5];
}
//-->
</SCRIPT>
	<TD class=table_head><?php  echo getlang("เลือกจากตัวอย่าง::l::Choose form template");?></TD>
	<TD class=table_td colspan=2><?php 
	$numtp=tmq("select * from serials_numberingtype order by name");
	?> <SELECT NAME="setnumberingtp" onchange="localfillthis(this.value)">
		<OPTION VALUE="" >
	<?php  while ($numtpr=tmq_fetch_array($numtp)) {?>
		<OPTION VALUE="<?php  echo $numtpr[field1]."|".$numtpr[field2]."|".$numtpr[field3]."|".$numtpr[field2e]."|".$numtpr[field3e]."|".$numtpr[marccode]?>" ><?php  echo getlang($numtpr[name])?>
	<?php }?>
	</SELECT></TD>
</TR>
<TR>
	<TD class=table_head><?php  echo getlang("ลำดับที่ 1::l::1st Numbering");?></TD>
	<TD class=table_td colspan=2><INPUT TYPE="text" NAME="field1" ID="field1" size=9 value="<?php  echo $serialinfo[enum1];?>"></TD>
</TR>
<TR>
	<TD class=table_head><?php  echo getlang("ลำดับที่ 2::l::2nd Numbering");?></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="field2" ID="field2" size=9 value="<?php  echo $serialinfo[enum2];?>"></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="field2tp" ID="field2tp" size=40 value="<?php  echo $serialinfo[enumr2];?>"></TD>
</TR>
<TR>
	<TD class=table_head><?php  echo getlang("ลำดับที่ 3::l::3rd Numbering");?></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="field3" ID="field3" size=9 value="<?php  echo $serialinfo[enum3];?>"></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="field3tp" ID="field3tp" size=40 value="<?php  echo $serialinfo[enumr3];?>"></TD>
</TR>
<TR>
	<TD class=table_head><?php  echo getlang("Frequency Code");?></TD>
	<TD class=table_td colspan=2><INPUT TYPE="text" NAME="marccode" ID="marccode" size=5 value="<?php  echo $serialinfo[marccode];?>"> <?php 
	html_libmann("serial_marc_freqcode","no");
	?></TD>
</TR>
<TR>
	<TD class=table_td colspan=3 align=center><INPUT TYPE="submit" value="Save" class=a_btn></TD>
</TR>
</TABLE></div>
</td>
</form>
</tr>
<?php 
if ($haltserialinfo=="yes") {
	die ("</table>");
}
?>

<TR>
	<TD class=table_head><?php  echo getlang("เล่มล่าสุด::l::Latest Vol.");?></TD>
	<TD class=table_td>
<?php 
$latest=tmq("select * from media_mid where pid='$MID' and (RESOURCE_TYPE='serial' or RESOURCE_TYPE='c-serial') and (jchrono_1<>'0' or jchrono_2<>'0' or jchrono_3<>'0') and bcode<>'' order by jchrono_1 desc, jchrono_2 desc, jchrono_3 desc,jenum_1 desc,jenum_2 desc,jenum_3 desc, jenum_4 desc, jenum_5 desc , jenum_6 desc",false);
if (tmq_num_rows($latest)<>0) {
	$havelatest="yes";
	$latest=tmq_fetch_array($latest);
	echo marc_getserialcalln($latest[id],"sum");
	echo " (";
	echo "$latest[jchrono_1]";
	if ($latest[jchrono_2]!=0) {
		echo "-$latest[jchrono_2]";
	}
	if ($latest[jchrono_3]!=0) {
		echo "-$latest[jchrono_3]";
	}
	echo ")";
} else {
	$havelatest="no";
	echo "-";
}
?>	
	</TD>
</TR>
<TR>
	<TD class=table_head><?php  echo getlang("เล่มต่อไป::l::Next Vol.");?></TD>
	<TD class=table_td><?php 
if ($havelatest=="yes") {
	//printr($latest);
	$next_dat=$latest[jchrono_3]+$rectps[inc_day];
	$next_mon=$latest[jchrono_2]+$rectps[inc_mon];
	$next_yea=$latest[jchrono_1]+$rectps[inc_yea];
	
	if ($rectps[inc_mon]!=0 && $next_dat==0) {
		 $next_dat=1;
		 $next_dat_skipdat="yes";
	}
	//echo "[$next_dat,$latest[jchrono_2]->$next_mon,$next_yea]";
	$caler=ymd_mkdt($next_dat,$next_mon,$next_yea-543);
	$next_dat=date("j",$caler);
	$next_mon=date("n",$caler);
	$next_yea=date("Y",$caler)+543;
	if ($latest[jchrono_3]=="" && $rectps[inc_day]==0) {
		$next_dat=0;
	}
	//echo "[$next_dat,$next_mon,$next_yea]";
	/////////start find next enum
	function local_findjnumindex($search,$haystack,$add) {
		if ("$haystack"=="-1") {
			$res=Array();
			$res[addlater]=0;
			$res[nexte]=($search+1);
			return $res;
		}
		//echo "[local_findjnumindex($search,$haystack,$add)]";
		$haystacka=explode(',',$haystack);
		$locali=0;
		$res=Array();
		$res[addlater]=0;
		while (list($k,$v)=each($haystacka)) {
			if ($search==$v) {
				if ($locali>=count($haystacka)-1) {
				//echo "$search=$v ($locali>".count($haystacka)."-1";
					$res[nexte]=$haystacka[0];
					$res[addlater]=1;
				} else {
					$res[nexte]=$haystacka[$locali+1];
					$res[addlater]=0;
				}
			}
			$locali++;
		}
		return $res;
	}
	$_nextenum=Array();
	$addlater=0;
	for ($enumi=6;$enumi>=2;$enumi--) {
		if ($serialinfo["enum$enumi"]!="") {
			$tmpnext=local_findjnumindex($latest["jenum_$enumi"],$serialinfo["enumr$enumi"],$addlater);
			$_nextenum[$enumi]=$tmpnext[nexte];
			$addlater+=$tmpnext[addlater];
		}
	}
	$_nextenum[1]=$latest["jenum_1"];
	if ($addlater>0) {
		$_nextenum[1]=$_nextenum[1]+1;
	}
	//fix 1 enum
	$chkfix1enum=tmq("select * from serial_info where mid='$MID' and enum1<>'' and enum2='' and enum3='' and enum4='' and enum5='' and enum6=''  ");
	if (tnr($chkfix1enum)==1) {
   		$_nextenum[1]=$_nextenum[1]+1;
	}
	//printr($_nextenum);

	/////////end find next enum
	echo "<A class=a_btn HREF='addMedia_type.php?USESMOD=$USESMOD&MID=$MID&MIDpage=$MIDpage&next_yea=$next_yea&next_mon=$next_mon&next_dat=$next_dat&next_dat_skipdat=$next_dat_skipdat&next_dat_enum1=$_nextenum[1]&next_dat_enum2=$_nextenum[2]&next_dat_enum3=$_nextenum[3]'>";
	echo "$next_yea";
	if ($next_mon!=0) {
		echo "-". $thaimonstr[$next_mon];
	}
	if ($next_dat!=0 && $next_dat_skipdat!="yes") {
		echo "-$next_dat";
	}
	echo " [$serialinfo[enum1] $_nextenum[1] $serialinfo[enum2] $_nextenum[2] $serialinfo[enum3] $_nextenum[3]]";
	//var_dump($serialinfo);
	for ($ei=0;$ei<=3;$ei++) {
		$currenti=$latest["jenum_$ei"];
	}
	
	echo "</A>";
} else {
	echo "-";
}
	?></TD>
</TR>
</table><?php 
//echo tmq_num_rows($rectp)."-$rectype";
if (tmq_num_rows($rectp)==0) {
	 html_dialog("ดำเนินการต่อไม่ได้::l::Could not continue","ระบบวารสารไม่สามารถดำเนินการกับรายการนี้ต่อได้ หากไม่มีการระบุรูปแบบการรับ::l::System could not continue, without specific recieve type");
	 if ($rectype!="") {
	  html_dialog("ดำเนินการต่อไม่ได้::l::Could not continue","This Bib. have rectype='$rectype' ");
	 }
	 die;
}
?>
</TD>
</TR>
</TABLE>
<CENTER>
<table border="0" cellpadding="0" cellspacing="0" width=<?php  echo $_TBWIDTH;?> align=center>
<tr>
	<td><font class=smaller2><?php  echo getlang("การแจ้งเตือนวารสารที่ถึงกำหนดออก::l::Alert an Expected issue");
	echo ": ";
	$chkmute=tmq("select * from serial_muteexpect where mid='$MID' ");
	if (tnr($chkmute)==0) {
		echo "<a href=\"$PHP_SELF?MID=$MID&setmute=yes\"><b style='color: darkgreen' class=smaller2>".getlang("การเตือนเปิดอยู่::l::Show")."</b></a>";
	} else {
		echo "<a href=\"$PHP_SELF?MID=$MID&setunmute=yes\"><b style='color: darkred' class=smaller2>".getlang("การเตือนปิดอยู่::l::Muted")."</b></a>";
	}
	?></font></td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width=<?php  echo $_TBWIDTH;?> align=center>
<tr><td>
<?php 
	$module=get_itemmodule($MID);
	if ($module!="serial") {
	  html_dialog("","This module manage only Serials");
		die;
	} 
		//printr($rectps);
		if ($USESMOD=="list") {
			include("serial_module.php");
		} else {
			include("serial_module_box.php");
		}

?>

</td></tr>
</table>


</CENTER><?php 
	index_reindex($MID);
	index_indexft($MID,true);
	serial_rebuild_serialstr($MID);
	
// auto name attatched	
$sb1="SELECT *  FROM media_mid where pid='$MID' ";	
$sb1="$sb1 group by jenum_1,jenum_2,jenum_3,jenum_4,jenum_5,jenum_6,calln";
$sql1 ="$sb1" ; 
$result = tmq($sql1,false);
while($row = tmq_fetch_array($result)) {
   $row[jpublicnote]=strtolower($row[jpublicnote]);
   //printr($row);
   $pos = strpos(" ".$row[jpublicnote], "bound");
   if ($pos === false) {
      $thiscalln=trim(serial_get_volstr($row[id]));
      $keyid="SERIAL-$row[pid]-attatch-$row[jenum_1]-$row[jenum_2]-$row[jenum_3]-$row[jenum_4]-$row[jenum_5]-$row[jenum_6]-$row[calln]";
      tmq("update globalupload set filename_auto ='".addslashes($thiscalln)."' where keyid='$keyid' ",false);
   } 
}
  foot();
  ?>