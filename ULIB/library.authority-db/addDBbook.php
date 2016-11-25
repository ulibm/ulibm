<?php  
;
     include("../inc/config.inc.php");
	head();
	?>
	<style>
	.tagtr {
		border-color: #797979;
		border-style: solid;
		border-width: 0px;
		border-top-width: 1px;
		border-left-width: 1px;
	}
	</style>
	<?php  
	include("_REQPERM.php");
	$librarian_autotagid=getval("MARC","librarian_tagname");
	$helpsuggeststr_dc=getval("MARC","dc_tagname");
	$helpsuggeststr_lc=getval("MARC","lc_tagname");
	//$helpsuggeststr_title=getval("MARCdsp","titletag");
	$helpsuggeststr_auth=getval("MARCdsp","authtag");
	$helpsuggeststr_localcallc=getval("MARC","def_local_callnum");
	mn_lib();
	function local_indiform($formname,$default,$current) {
		//echo "[$formname,$default,$current]";
					$defindi1=$default;
					/*
					$defindi1=str_replace(" ","",$defindi1.",".$current);
					if ($current!="") {
						$defindisel=$current;
					} else {
						$defindisel=$defindi1[0];
					}
					*/
					$defindi1=$defindi1.",_";
					$defindi1=trim($defindi1,',');
					$defindi1=str_replace("b",'_',$defindi1);
					$defindi1=explode(",",$defindi1);
					$defindi1 = array_unique($defindi1);
					sort($defindi1);
					
					echo "<SELECT NAME='$formname'>";
					echo "<option selected style='background-color: #F0F9E8' value='$current'>$current</option>";
					foreach ($defindi1 as $defindi1i) {
						echo "<option value='$defindi1i'>$defindi1i</option>";
					}
					echo "</SELECT>";
	}
?><SCRIPT LANGUAGE="JavaScript">
<!--
KB_CTRL_Rdb=Array();
var isCtrlKBPressed = false;
var isShiftKBPressed = false;
var isAltKBPressed = false;
document.onkeyup=function(e) {
    if(e.which == 17) isCtrlKBPressed=false;
    if(e.which == 16) isShiftKBPressed=false;
    if(e.which == 18) isAltKBPressed=false;
}
document.onkeydown=function(e){
    if(e.which == 17) isCtrlKBPressed=true;
    if(e.which == 16) isShiftKBPressed=true;
    if(e.which == 16) isAltKBPressed=true;
	if(isAltKBPressed==true && isShiftKBPressed == true && isCtrlKBPressed == true && setlastfocusstr!="none") {
		if((e.which >= 65 && e.which <=90) || (e.which >= 48 && e.which <=57)) {
			 tmp=getobj(setlastfocusstr); tmps=tmp.value=tmp.value+'^'+String.fromCharCode(e.which).toLowerCase();
		}
		return false;
	}
    if(e.which == 82 && isCtrlKBPressed == true) {
		//ctrl+R
         eval(KB_CTRL_Rdb[setlastfocusstr_tag]);
         return false;
    }
    if(e.which == 83 && isCtrlKBPressed == true) {
		//ctrl+S
         if (setlastfocusstr!="none") {
			 tmp=getobj(setlastfocusstr);
			 tmp.value=tmp.value+'^'
         }
         return false;
    }

}


	strtmpaz="<?php echo $_STR_A_Z;?>";
	strtmpaz=strtmpaz.split(',');
	strtmpaz.reverse();

function doubleclicktag(wh) {
	clonestr=""+wh.value+"";
	if (clonestr=='') {
		wh.value='^a';
		return false;
	} 
	if (clonestr.indexOf("^z")!=-1) {
		return false;
	}
	for (strtmpazi in strtmpaz) {
		if (clonestr.indexOf("^"+strtmpaz[strtmpazi])!=-1) {
			wh.value = wh.value + "^"+strtmpaz[strtmpazi-1];
			return false;
		}
	}
	return false;
}

setlastfocusstr="none";
setlastfocusstr_tag="none";
function setlastfocus(wh,whrem) {
	//tmp=getobj(wh);
	//alert(tmp.value);
	//tmp2=tmp.value+"";
	//tmp2=tmp2.replace('^a^a','^a');
	//tmp.value=tmp2
	setlastfocusstr=wh
	setlastfocusstr_tag=whrem
}
function removemarc(wh) {
	//alert(wh);
	getobj(wh).innerHTML="";
	getobj(wh).outerHTML="";
}
function duplicatemarc(wh,indi1,indi2,after2,isdelable) {

	if (indi1==undefined || indi1=="") {
		indi1="_";
	}
	if (indi2==undefined || indi2=="") {
		indi2="_";
	}
	if (isdelable==undefined) {
		isdelable="yes";
	}
	if (indi1==" ") {
		indi1="_";
	}
	if (indi2==" ") {
		indi2="_";
	}
	if (after2==undefined) {
		after2="";
	}
	/*
	if (indi1=="" || indi2=="")
	{
		alert(indi1+"="+indi1)
		alert(indi2+"="+indi2)
	}
	*/
	/*
	if (wh=='tag245') {
		alert(after2);
	}
	*/
	if (wh=='<?php echo $librarian_autotagid; ?>') {
		if (after2=="") {
			 after2="^a<?php echo get_library_name($useradminid)?>";
		}
	}
	//alert(document.all["source_"+wh].innerHTML);
	newhtml=getobj("source_"+wh).innerHTML;
		tmpcb=document.getElementsByName("data["+wh+"][]");
		tmpcbi1=document.getElementsByName("dataindi1["+wh+"][]");
		tmpcbi2=document.getElementsByName("dataindi2["+wh+"][]");
		//alert(getobj("result_"+wh).innerHTML);
		var savemode=Array();
		var savemodei1=Array();
		var savemodei2=Array();
		for (tmpcbx = 0; tmpcbx<tmpcb.length; tmpcbx++) {
			savemodei1[tmpcbx]=tmpcbi1[tmpcbx].selectedIndex
			savemodei2[tmpcbx]=tmpcbi2[tmpcbx].selectedIndex
			savemode[tmpcbx]=tmpcb[tmpcbx].value
			//alert(tmpcb[tmpcbx].value); 
			//alert(savemode[tmpcbx]); 
		}

	newhtml="<span ID='[RANDOMHERE]'>"+newhtml+"  ";
	if (isdelable!='no')	{
		newhtml=" "+newhtml+" <B onclick=\"removemarc('[RANDOMHERE]')\"> <IMG SRC='../neoimg/red.gif' WIDTH=21 HEIGHT=21 BORDER=0 ></B><BR>";
	} else {
		newhtml=" "+newhtml+"  <IMG SRC='../neoimg/red-dis.gif' WIDTH=21 HEIGHT=21 BORDER=0 ><BR>";
	}
	newhtml=""+newhtml+"</span>"
	newid=Math.floor(Math.random()*1000000);
	newid="NEWITEM"+newid;
	//after2=addslashes(after2);

	newhtml=newhtml.replace("[CONTROLTAGNAME]",wh);
	newhtml=newhtml.replace("[CONTROLTAGNAME]",wh);
	newhtml=newhtml.replace("[CONTROLTAGNAME]",wh);
	newhtml=newhtml.replace("[CONTROLTAGNAME]",wh);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);	
	newhtml=newhtml.replace("[CHOOSENINDI1]",indi1);
	newhtml=newhtml.replace("[CHOOSENINDI1]",indi1);
	newhtml=newhtml.replace("[CHOOSENINDI1]",indi1);
	newhtml=newhtml.replace("[CHOOSENINDI1]",indi1);
	newhtml=newhtml.replace("[CHOOSENINDI2]",indi2);
	newhtml=newhtml.replace("[CHOOSENINDI2]",indi2);
	newhtml=newhtml.replace("[CHOOSENINDI2]",indi2);
	newhtml=newhtml.replace("[CHOOSENINDI2]",indi2);

	if (ie==1) {
		newhtml=newhtml.replace("[INPUTEDDATA]","\""+after2+"\"");
		newhtml=newhtml.replace("[INPUTEDDATA]","\""+after2+"\"");
		newhtml=newhtml.replace("[INPUTEDDATA]","\""+after2+"\"");
		newhtml=newhtml.replace("[INPUTEDDATA]","\""+after2+"\"");		
	} else {
		newhtml=newhtml.replace("[INPUTEDDATA]",""+after2+"");		
		newhtml=newhtml.replace("[INPUTEDDATA]",""+after2+"");		
		newhtml=newhtml.replace("[INPUTEDDATA]",""+after2+"");		
		newhtml=newhtml.replace("[INPUTEDDATA]",""+after2+"");		
	}
	
	getobj("result_"+wh).innerHTML=getobj("result_"+wh).innerHTML+newhtml;
	//alert(after2);
	//alert(newhtml);
	for (tmpcbx = 0; tmpcbx<tmpcb.length; tmpcbx++) {
		if (savemode[tmpcbx]!=undefined) {
			tmpcb[tmpcbx].value=savemode[tmpcbx]
		}
		//	alert(tmpcbi1[tmpcbx]);
		if (tmpcbi1[tmpcbx]!=undefined) {
			tmpcbi1[tmpcbx].selectedIndex=savemodei1[tmpcbx]
		}
		if (tmpcbi1[tmpcbx]!=undefined) {
			tmpcbi2[tmpcbx].selectedIndex=savemodei2[tmpcbx]
		}
	}
	return newid;
}
//-->
</SCRIPT>
<!-- preload area -->
<IMG SRC="../neoimg/minus.gif" WIDTH="1" HEIGHT="1" BORDER="0" ALT="">
<IMG SRC="../neoimg/plus.gif" WIDTH="1" HEIGHT="1" BORDER="0" ALT="">
<IMG SRC="../neoimg/red.gif" WIDTH="1" HEIGHT="1" BORDER="0" ALT="">
<IMG SRC="../neoimg/red-dis.gif" WIDTH="1" HEIGHT="1" BORDER="0" ALT="">

                    <table width = "780" align=center border = "0" cellspacing = "0" cellpadding = "0">
                        <tr>
                            <td><?php  
            ?></td>
                        </tr>
                        <tr valign = "top">
                            <td>

<form name = "form1" method = "post" action = "addnewDBbook.php" ID="FaddDBbook">
<INPUT TYPE = "hidden" name = typeid value = "<?php echo $typeid; ?>">
<INPUT TYPE = "hidden" name = "libID" value = "<?php echo $useradminid; ?>">
<INPUT TYPE = "hidden" name = "startrow" value = "<?php echo $startrow; ?>">
<INPUT TYPE = "hidden" name = "chainmaster" value = "<?php echo $chainmaster; ?>">
<INPUT TYPE = "hidden" name = "chainid" value = "<?php echo $chainid; ?>">
<?php  
if ($IDEDIT!="") {
  
  html_label('b',$IDEDIT);
	$x="select * from authoritydb where ID='$IDEDIT' ";
	$x=tmq($x);
	if (tnr($x)!=1) {
		 html_dialog("","Error ผิดพลาด ไม่พบรายการที่ต้องการแก้ไข");
		 foot();
		 die;
	}
	$x=tmq_fetch_array($x);




}
?><BR><?php  
	$fixedwidthfield=getval("MARC","fixedwidthfield");
$fwdat=$x[$fixedwidthfield];
$LEADER=$x[leader];
//echo "[$fwdat]";




if ($yazid!="") {
	$yaz=tmq("select * from yaz_saved where id='$yazid' ");
	if (tmq_num_rows($yaz)==0) {
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("ไม่สามารถหาหมายเลขข้อมูลนำเข้า หมายเลข <?php echo $yazid;?>");
		//-->
		</SCRIPT><?php  
	} else {
		$yaz=tmq_fetch_array($yaz);	

$yaz=explodenewline($yaz[marcinfo]);
//printr($yaz);
$_STR_A_Za=explode(',',$_STR_A_Z);
foreach ($yaz as $yazvalue) {
	$yazdec="tag".substr($yazvalue,0,3);
	//echo "[$yazdec]";
	$yazstr=substr($yazvalue,4,2).(substr($yazvalue,7));
	//$yazstr=str_replace($newline,"^",$yazstr);
	$yazstr=str_replace('$',"^",$yazstr);
	$yazstr=str_replace('|',"^",$yazstr);
	//$yazstr=trim($yazstr);
	//echo "[$yazstr]";
	$yazstr=removenewline($yazstr);
	//echo "[$yazstr]<BR>";
	reset($_STR_A_Za);
	while (list($azk,$azv)=each($_STR_A_Za)) {
		$yazstr=str_replace("^$azv ","^$azv",$yazstr);
	}
	/*
	if ($yazdec=="tag505") {
		for($xi=0;$xi<=strlen($yazstr);$xi++ ) { 
			//echo "$yazstr[$xi]=".ord($yazstr[$xi])."<BR>";
		}
	}
	echo "<HR>";
	*/
	$x[$yazdec]=$x[$yazdec].$newline.$yazstr;
	$x[$yazdec]=trim($x[$yazdec],$newline);
}


		
	}
} // end if ($yazid!="") 

if ($usethemarc=="yes") {
	//echo $THEMARC;
	$THEMARC=explodenewline($THEMARC);
	//printr($THEMARC);
	$_STR_A_Za=explode(',',$_STR_A_Z);
	$lastyaztag="";
	foreach ($THEMARC as $yazvalue) {
		if (trim(substr($yazvalue,0,3))!="") {
			$lastyaztag=substr($yazvalue,0,3);
		} else { 
			//echo "[".str_replace(" ",'-',$yazvalue)."]<BR>";
			$yaztoadd=substr($yazvalue,7);
			$yaztoadd=str_replace('$',"^",$yaztoadd);
			$yaztoadd=str_replace('|',"^",$yaztoadd);
			$yaztoadd=str_replace('\\',"^",$yaztoadd);
			$yaztoadd=str_replace('\t',"^",$yaztoadd);
			$yaztoadd=str_replace('\r',"^",$yaztoadd);
			$yaztoadd=str_replace('^^',"^",$yaztoadd);
			$x["tag".$lastyaztag]=$x["tag".$lastyaztag].$yaztoadd;
		}
		$yazdec=trim("tag".substr($yazvalue,0,3));
		//echo "[$yazdec]";
		$yazstr=substr($yazvalue,4,2).(substr($yazvalue,7));
		$yazstr=str_replace('$',"^",$yazstr);
		$yazstr=str_replace('|',"^",$yazstr);
		$yazstr=str_replace('\\',"^",$yazstr);
		$yazstr=str_replace('\t',"^",$yazstr);
		$yazstr=str_replace('\r',"^",$yazstr);
		$yazstr=str_replace('^^',"^",$yazstr);
		$yazstr=removenewline($yazstr);
		reset($_STR_A_Za);
		while (list($azk,$azv)=each($_STR_A_Za)) {
			$yazstr=str_replace("^$azv ","^$azv",$yazstr);
		}
		$x[$yazdec]=$x[$yazdec].$newline.$yazstr;
		$x[$yazdec]=trim($x[$yazdec],$newline);
		$x[$yazdec]=rtrim($x[$yazdec]);
		$x[$yazdec]=stripslashes($x[$yazdec]);
	}
	//printr($x);
} //($usethemarc=="yes") 

function local_fwi($txt,$inputname,$s,$length,$default,$isfocus="no") {
	global $fwdat;
	$txts=explode(":",$txt);
	$alert=$txts[1];
	$txt=$txts[0];
	echo "<font class=smaller>$txt</font>";
	if ($alert!="") {
		$alert=str_replace("&","\\n",$alert);
		?> <A HREF="javascript:alert('<?php  echo $alert?>');"><IMG SRC="../neoimg/tip.png" WIDTH="14" HEIGHT="14" BORDER="0" ALT="" align=absmiddle></A><?php  
	}
	$val=substr($fwdat,$s,$length);
	if ($default!="" && $val=="") {
		$val=$default;
	}
	$val=str_fixw($val,$length," ");

	?>
	<INPUT TYPE="text" 
	NAME="<?php  echo $inputname;?>" 
	value="<?php  echo $val;?>" 
	size=<?php  echo $length;?> 
	maxlength=<?php  echo $length;?>
	onfocus="this.select()" <?php  
	if ($isfocus!="no") {
		 ?> style='border-color: #FF0000; border-width: 1px;border-style: solid;' <?php  
	}
	?>
	onblur="chkleng(this,<?php  echo $length;?>)"> <?php  
}

function local_ldi($txt,$inputname,$s,$length,$default,$ishide=false,$setval="",$isfocus="no") {
	global $LEADER;
	$txts=explode(":",$txt);
	$alert=$txts[1];
	$txt=$txts[0];
	echo "<font class=smaller>$txt</font>";
	if ($alert!="") {
		$alert=str_replace("&","\\n",$alert);
		?> <A HREF="javascript:alert('<?php  echo $alert?>');"><IMG SRC="../neoimg/tip.png" WIDTH="14" HEIGHT="14" BORDER="0" ALT="" align=absmiddle></A><?php  
	}
	$val=substr($LEADER,$s,$length);
	if ($setval!="") {
		$val=$setval;
	}
	if ($default!="" && $val=="") {
		$val=$default;
	}
	$val=str_fixw($val,$length,"0");

	if ($ishide==false) {
		?>
		<INPUT TYPE="text" 
		NAME="<?php  echo $inputname;?>" 
		value="<?php  echo $val;?>" 
		size=<?php  echo $length;?> 
		maxlength=<?php  echo $length;?> 
		onfocus="this.select()"
		onblur="return chkleng(this,<?php  echo $length;?>)"
			<?php  	if ($isfocus!="no") {
			 ?> style='border-color: #FF0000; border-width: 1px; border-style: solid;' <?php  
		 }?>
		> <?php  
	} else {
		?><INPUT TYPE="hidden" 
		NAME="<?php  echo $inputname;?>" 
		value="<?php  echo $val;?>" 
		> 
		<B class=smaller><?php  echo str_fixw($val,$length);?></B><?php  
	}
}

?><SCRIPT LANGUAGE="JavaScript">
<!--
function chkleng(wh,s) {
	tmp=""+wh.value
	if (tmp.length!=s) {
		alert("กรุณากรอกให้ครบ " + s + " ตัวอักษร\nหากไม่ต้องการกรอก ให้กรอก Space (กด Spacebar) แทนตัวอักษร");
		wh.style.backgroundColor='orange';
		return false;
	} else {
		wh.style.backgroundColor='white';
	}
}
//-->
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!--
leaderstatus=0
function showhide_leadersub() {
	if (leaderstatus==1) {
		leaderstatus=0
		getobj('imgleaderobj').src='../neoimg/plus.gif';
		getobj('leaderhider').style.display='none';
	} else {
		leaderstatus=1
		getobj('imgleaderobj').src='../neoimg/minus.gif';
		getobj('leaderhider').style.display='block';
	}
}
fixfieldstatus=0
function showhide_fixfieldsub() {
	if (fixfieldstatus==1) {
		fixfieldstatus=0
		getobj('imgfixwobj').src='../neoimg/plus.gif';
		getobj('fixwhider').style.display='none';
	} else {
		fixfieldstatus=1
		getobj('imgfixwobj').src='../neoimg/minus.gif';
		getobj('fixwhider').style.display='block';
	}
}

//-->
</SCRIPT>

<TABLE border=0 width=780 align=center cellspacing=0 cellpadding=2 >
<TR>
	<TD colspan=3 align=center bgcolor=f0f0f0><B>LEADER</B> <A HREF="javascript:void(0)" startval=hide
onclick="showhide_leadersub();"
	><IMG SRC="../neoimg/plus.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" ID=imgleaderobj></a></TD>

</TR>
<TR>
	<TD><span style='display: none;' id=leaderhider><TABLE width=100%>


<TR>
  <TD width="20%"><?php  local_ldi("Logical record length:เป็นส่วนที่ระบุความยาวของอักชระทั้งหมดของระเบียน ส่วนนี้โปรแกรมจะประมวลผลให้","ld_1",0,5,"",true);?></TD>
  <TD width="20%"><?php  local_ldi("Record.Status:สถานภาพของระเบียน&a - Increase in encoding level&c - Corrected or revised&d - Deleted&n - New&p - Increase in encoding level from prepublication","ld_2",5,1,"n");?></TD>
  <TD width="20%"><?php  local_ldi("Type of Record:a - Language material&c - Printed music&d - Manuscript music&e - Cartographic material&f - Manuscript cartographic material&g - Project medium&i - Nonmusical sound recording&k - Two-dimensional nonprojectable graphic&m - Computer file&o - Kit&p - Mixed materials&r - Three-dimensional artifact or naturall occurring object&t - Manuscript language material","ld_3",6,1,"a");?></TD>
 </TR>
<TR>
  <TD width="20%"><?php  local_ldi("Bibliographic level:ระดับบรรณานุกรม&a - Monograhpic component part&b - Serial component part&c - Collection&d - Subunit&m - Monograph&s - Serial","ld_4",7,1,"a","","","yes");?></TD>
  <TD width="20%"><?php  local_ldi("Type of Control:ตำแหน่งที่ระบุประเภทของการควบคุมเอกสาร&฿ - No specified type&a - Archival control","ld_5",8,1," ");?></TD>
  <TD width="20%"><?php  local_ldi("Character coding scheme:อักขระที่ใช้ในระเบียน&฿ - MARC-8&a - UCS/Unicode","ld_6",9,1," ");?></TD>
 </TR>
 <TR>
  <TD width="20%"><?php  local_ldi("Indicator count:ตำแหน่งที่บอกตัวบ่งชี้ในแต่ละเขตข้อมูล&มีค่าเป็น 2 เสมอ","ld_7",10,1,"",true,"2");?></TD>
  <TD width="20%"><?php  local_ldi("Subfield code count:จำนวนของรหัสเขตข้อมูลย่อย&มีค่าเป็น 2 เสมอ","ld_8",11,1,"2",true);?></TD>
  <TD width="20%"><?php  local_ldi("Base address of data:อักขระตัวแรกของเขตข้อมูลควบคุมเขตแรก&ส่วนนี้ระบบดำเนินการให้","ld_9",12,5,"",true);?></TD>
 </TR>
 <TR>
  <TD width="20%"><?php  local_ldi("Encoding level:ระดับความสมบูรณ์ของการลงรายการบรรณานุกรม&1 - Full level, materials not examined&2 - Less-than-full level, material not examined&3 - Abbreviated level&4 - Core level&5 - Partial (preliminary) level&7 - Minimal level&8 - Prepublicaion level&u - Unknow&z - Not applicable","ld_10",17,1,"u");?></TD>
  <TD width="20%"><?php  local_ldi("Descriptive cataloging form:ระบุว่า ระเบียนนี้ได้ลงรายการตาม AACR2 หรือไม่&฿ - Non-ISBD&a - AACR2& i - ISBD&u - Unknown","ld_11",18,1,"u");?></TD>
  <TD width="20%"><?php  local_ldi("Linked Record Requirement:หมายเหตุที่อยู่ในเขตข้อมูลเชื่อมโยง สามารถนำไปใช้ได้โดยไม่ต้องเข้าถึงระเบียนจริงหรือไม่&฿ - Related record not required&r - Related record required","ld_12",19,1," ",false);?></TD>
 </TR>
 <TR>
  <TD width="20%"><?php  local_ldi("Length Of The length-of-field portion:ตำแหน่งที่ระบุความยาวของเขตข้อมูล&มีค่าเป็น 4 เสมอ","ld_13",20,1,"",true,"4");?></TD>
  <TD width="20%"><?php  local_ldi("Length Of The starting-character-position portion:ตำแหน่งที่ระบุความยาวของตำแหน่งเริ่มของเขตข้อมูล&มีค่าเป็น 5 เสมอ","ld_14",21,1,"",true,"5");?></TD>
   <TD width="20%"><?php  local_ldi("Length Of The inplementation-defined portion:ใน MARC 21 นามานุกรมเขตข้อมูลไม่มีส่วนของตำแหน่งที่กำหนดการติดตั้ง จึงใช้เป็นเลข 0 เสมอ","ld_15",22,1,"",true,"0");?></TD>
</TR>
 <TR>
  <TD width="20%"><?php  local_ldi("Undefined:ยังไม่มีการใช้งาน จึงใช้ 0 เสมอ","ld_16",23,1,"",true,"0");?></TD>

 </TR>

	</TABLE></TD>
</TR>

</TABLE>
<TABLE border=0 width=780 align=center cellspacing=0 cellpadding=2 >
<TR>
	<TD colspan=5 align=center bgcolor=f0f0f0><B>Fixed Width field</B> [<?php  echo $fixedwidthfield?>]  <A HREF="javascript:void(0)" startval=hide
onclick="showhide_fixfieldsub();"
	><IMG SRC="../neoimg/plus.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" ID=imgfixwobj></a></TD>

</TR>
<TR>
	<TD>
	<span style='display: none;' id=fixwhider>
	<TABLE width=100%>




<TR>
  <TD width="40%" colspan=2><?php  local_fwi("Date Enter:Date entered on file&รูปแบบ= yymmdd&yy - เลขสองตัวสุดท้ายของปี&mm - ตัวเลข 2 ตัวของเดือน&dd - ตัวเลข 2 ตัวของวัน","fw_1",0,6,date("ymd"));?></TD>
  <TD width="20%"><?php  local_fwi("Date Type:Type of date/Publication status&ประเภทของปีพิมพ์หรือสถานภาพของสิ่งพิมพ์&b - No dates given, B.C. date involved&e - Detailed date&i - Inclusive dated of collection&K - Range of years of bulk of collection&m - Multiple dates&n - Dates unknown&p - date of distribution/release/issue and production/reording session when differen&q - Questionable date&r - Reprint/reissue date and original date&s - Single known date/probable date&t - Publication date and copyright date","fw_2",6,1,"s");?></TD>
  <TD width="20%"><?php  local_fwi("Date 1:ปีพิมพ์ 1","fw_3",7,4,"||||","yes");?></TD>
  <TD width="20%"><?php  local_fwi("Date 2:ปีพิมพ์ 2","fw_4",11,4,"||||");?></TD>

	</TR>

<TR>
  <TD width="20%"><?php  local_fwi("Place:Place of publication, production, or execution&สถานที่พิมพ์ &ต้องกรอก 3 ตัวอักษร กรณีที่ไม่ถึง ให้ใส่ ฿  เช่น  th฿","fw_5",15,3,"th ");?></TD>
  <TD width="20%"><?php  local_fwi("Illus:Illustrations&ภาพประกอบ&฿ - No illustration&a - Illustrations& b - Maps&c - Portraits&d - Charts&e - Plans&f - Plates&g - Music&h - Facsimiles&j - Coats of arms&j - Genealogical tables&k - Forms& l - Samples&m - Phonodisc, phomowire, etc&o - Photographs&p - Illumination","fw_6",18,4," ");?></TD>
  <TD width="20%"><?php  local_fwi("Audience:Target Audience&กลุ่มเป้าหมาย&฿ - Unknown or not specified&a - Preschool&b - Primary&c - Elementary and junior high&d - Secondary (senior hign)&e - Adult&f - Specialized&g - General&j - Juvenile","fw_7",22,1," ");?></TD>
  <TD width="20%"><?php  local_fwi("Form:Form of item&รูปแบบของวัสดุ&฿ - None of following&a - Microfilm&b - Microfiche&c - Microopaque&d - Large print&f - Braille&r - Regular print reproduction&s - Electronic","fw_8",23,1," ");?></TD>
  <TD width="20%"><?php  local_fwi("Content:Nature of Contents&ลักษณะเนื้อหา&฿ - No specifiec nature of contents&a - Abstracts/summaries&b - Bibliographies&c - Catalogs&d - Dictionaries&e - Encyclopedias&f - Handbooks&g - Legal articles&i - Indexes&j - Patent document&k - Discographies&l - Legislation&m - Theses&n - Surveys of literature in a subject area&o - Reviews&p - Programmed texts&q - Filmographies&r - Directories&s - Statistics&t - Technical reports&v - Legal cases and case notes&w - Law reports and digests&z - Treaties","fw_9",24,4," ");?></TD>
  </TR>
<TR>
  <TD width="20%"><?php  local_fwi("Gov.:Government publication&สิ่งพิมพ์รัฐบาล&฿ - Not a government publication&a - Autonomous or semi-autonomous component&c - Multilocal&f - Federal/National&i - International intergovernment&l - Local&m - Multistate&o - Government publication - level undetermined&s - State, provincial, territorial, dependent&u - Unknown if item is govenment publication&z - Other","fw_10",28,1," ");?></TD>
  <TD width="20%"><?php  local_fwi("Conf.:Conference publication&เอกสารการประชุม&0 - not a confetence publication&1 - Conference publication","fw_11",29,1,"0");?></TD>
  <TD width="20%"><?php  local_fwi("Fest.:Festschrift&หนังสือที่ระลึก&0 - Not festschrift&1 - Festschrift","fw_12",30,1,"0");?></TD>
  <TD width="20%"><?php  local_fwi("Ind.:Index&ดรรชนี&0 - No index&1 - Index present","fw_13",31,1,"0");?></TD>
  <TD width="20%"><?php  local_fwi("Undefined","fw_14",32,1," ");?></TD>
  </TR>
<TR>
  <TD width="20%"><?php  local_fwi("Literary form:รูปแบบวรรณกรรม&0 - Not fiction (not further specified)&1 - Fiction (not further specified)&c - Comic strips&d - Dramas&e - Essays&f - Novels&h - Humor, satires, etc&i - Letters&j - Short stories&m - Mixed forms&p - Poetry&s - Speaches&u - Unknown","fw_15",33,1,"0");?></TD>
  <TD width="20%"><?php  local_fwi("Biog:Biography&ชีวประวัติ&฿ - No biographical material&a - Autobiography&b - Individual biography&c - Collective biography&d - Contains biographical information","fw_16",34,1," ");?></TD>
  <TD width="20%"><?php  local_fwi("Lang:Language&ภาษา&ใช้ตาม MARC Code List for Language&฿฿฿ - Blanks&mul - Multiple languages&sgn - Sign anguages&und - ใช้สำหรับภาษาที่ไม่สามารถตัดสินใจได้ว่าเป็นภาษาใด","fw_17",35,3,"tha","yes");?></TD>
  <TD width="20%"><?php  local_fwi("mod.:Modified recrd&฿ - Not modified&s - Shorten& d Dashed-on information omitted&x - Missing characters&r - Completely romanized/printed cards in scrip&o - Completely romanized/ printed catds romanized","fw_18",38,1," ");?></TD>
  <TD width="20%"><?php  local_fwi("source:Cataloging source&แหล่งที่ทำการวิเคราะห์&฿ - National Bibliographic agency&c - Cooperative cataloging program&d - Other&u - Unknown","fw_19",39,1,"d");?></TD>
  </TR>


	
	</TABLE>
	</span>
	</TD>
</TR>


</TABLE>

<table width =970 align = center border=0 cellpadding = 1 cellspacing = 0 bgcolor = #777777>
<?php  

$sql82="select * from bkedit_authority where systemhide='no' order by ordr";
$result=tmq($sql82);




                                        while ($row=tmq_fetch_array($result)) {
											//printr($row);
											$defaultindi1=substr($row[defindi1],0,1);
											$defaultindi2=substr($row[defindi2],0,1);
											if ($defaultindi1=="b") { $defaultindi1="_";}
											if ($defaultindi2=="b") { $defaultindi2="_";}
												if ($row[fid]==$fixedwidthfield) {
													continue;
												}



//load default value
if ($IDEDIT=="" && $usethemarc!="yes") {
	$x[$row[fid]]=$defvalue[$row[fid]];
	if ($defvalue[$row[fid]]!="") {
		$defaultindi1=substr($defvalue[$row[fid]],0,1);
		$defaultindi2=substr($defvalue[$row[fid]],1,1);
	}
}

?>
<tr bgcolor = "#f3f3f3" id="tr<?php  echo $row[fid]?>" valign=top
<?php  

if ($row[defshow]=='yes' || trim($x[$row[fid]])!="")	 {
	echo " style='display: block;' ";
} else {
	echo " style='display: none;' ";
}
?>>
<?php  
$infos="<B class=smaller>".addslashes(getlang("$row[name]"))."</B><BR>Detail:".addslashes(getlang("$row[descr]"))."<BR>Example:".addslashes(getlang("$row[example]"));
$infos=addslashes(str_replace($newline,"<BR>",$infos));?>
	<td class=tagtr width = "100"  align=center >
<A href="javascript:void(null);" onMouseover="fixedtooltip('<?php echo addslashes(str_replace($newline,"<BR>",$infos));?>', this, event, '550px')"  style="color: black ; font-weight: bold;" onMouseout="delayhidetip()"><?php  
	echo str_replace("tag","",$row[fid]);
		?><IMG SRC="../neoimg/tip.png" WIDTH="14" HEIGHT="14" BORDER="0" ALT="">
</A></td>	
<td class=tagtr width = "830">
		
		<TABLE border=0 width=830 cellpadding=0 cellspacing=0><!-- ตารางสำหรับจัดบรรทัดที่มี  (canrepeat=R) -->
		<TR valign=top><TD><span ID="source_<?php echo $row[fid]?>" style="display:none"><?php  
				if ($row[ishasindi]=="NO") {
						echo "<INPUT TYPE=text NAME=\"data[[CONTROLTAGNAME]][]\" AUTOCOMPLETE=off ID=\"data[RANDOMHERE]\" onblur=\"setlastfocus('data[RANDOMHERE]','$row[fid]');\" onfocus=\"setlastfocus('data[RANDOMHERE]','$row[fid]');\" value=\"[INPUTEDDATA]\" size=87 > ";
				} else {
					local_indiform("dataindi1[[CONTROLTAGNAME]][]",$row[defindi1],"[CHOOSENINDI1]");
					local_indiform("dataindi2[[CONTROLTAGNAME]][]",$row[defindi2],"[CHOOSENINDI2]");
					//print_r($defindi1);
					echo " <INPUT TYPE=text NAME='data[[CONTROLTAGNAME]][]' AUTOCOMPLETE=off ID='data[RANDOMHERE]' onblur=\"setlastfocus('data[RANDOMHERE]','$row[fid]');\" onfocus=\"setlastfocus('data[RANDOMHERE]','$row[fid]');\" value=\"[INPUTEDDATA]\"size=78 ondblclick=\"doubleclicktag(this)\">  ";
				}


		?></span><span ID="result_<?php echo $row[fid]?>"><span></TD>	
		<?php  
$source=explodenewline($x["$row[fid]"]);
		
			?><TD ><?php  
			if ($row[isrepeat]=="R") {	
				?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	KB_CTRL_Rdb["<?php echo $row[fid];?>"]="duplicatemarc('<?php echo $row[fid]; ?>','<?php echo $defaultindi1?>','<?php echo $defaultindi2?>','<?php  echo substr($defvalue[$row[fid]],2);?>');"; //copy from below;
//-->
</SCRIPT>
				<A HREF="javascript:void(null)" onclick="duplicatemarc('<?php echo $row[fid]; ?>','<?php echo $defaultindi1?>','<?php echo $defaultindi2?>','<?php  echo substr($defvalue[$row[fid]],2);?>');"><B><IMG SRC="../neoimg/plus.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle></B></A>
				<?php  
				} 

	?></TD>

		</TR>
		</TABLE></td>
		<TD class=tagtr width=32 align=center valign=top  style="padding-top:7"><?php  

	if ($row[issuggest]=="YES") {	
		?><B 
		 onclick="fixedtooltipforsuggest('suggestme.php?mid=<?php echo $IDEDIT; ?>&tagid=<?php echo $row[fid]; ?>', this, event, '500px','<?php echo getlang("ข้อมูลใกล้เคียง::l::Related Data");?>')" 
		 ><!-- suggest me --><img src="<?php echo $dcrURL?>neoimg/suggestme.png" border=0 width=24 height=24 hspace=0 vspace=0></B><BR>
	<?php  
	} else {
		?><img src="<?php echo $dcrURL?>neoimg/spacer.gif" border=0 width=24 height=24 hspace=0 vspace=0><?php  
	}			
?>
		 </TD>
		<TD valign=top style="padding-top:12; padding-left: 3; padding-right:3; border-right-width: 1;" class=tagtr>
			<a href="javascript:void(null)" onclick="getobj('tr<?php echo $row[fid]; ?>').style.display='none';getobj('tr<?php echo $row[fid]; ?>').style.height=0;getobj('link<?php echo $row[fid]; ?>').style.display='inline'; " ><IMG SRC="minimize.png" WIDTH="12" HEIGHT="12" BORDER="1" TITLE="<?php echo getlang("ซ่อนแท็ก::l::Hide"); ?>" style="border-color:#575757"></a></TD>

</tr>
<SCRIPT LANGUAGE="JavaScript">
	<!--
	firstid="";
<?php  
	$sourcecount=0;
	foreach ($source as $sourcei) {
		if (trim($sourcei)!="") {
			$sourcecount++;
					$first2_1=substr($sourcei,0,1);
					$first2_2=substr($sourcei,1,1);
					if ($row[ishasindi]=="NO") {
						$after2=$sourcei;
					} else {
						$after2=substr($sourcei,2);
					}
					if ($sourcecount==1) {
						$delete_able="no";
					} else {
						$delete_able="yes";
					}
					$after2=str_replace('"',"&quot;",$after2);
					$after2=removenewline($after2);
			?>
				firstid=duplicatemarc("<?php echo $row[fid];?>","<?php echo $first2_1;?>","<?php echo $first2_2;?>","<?php echo addslashes($after2);?>","<?php echo $delete_able;?>");
				<?php  
		}
	}
	//if ($sourcecount==0 && $row[isrepeat]!="R") {
	if ($sourcecount==0 ) {
		if ($row[isrepeat]!="R") {
			?>firstid=duplicatemarc("<?php echo $row[fid]; ?>","<?php echo $defaultindi1;?>","<?php echo $defaultindi2;?>","","no");<?php  
		} else {
			?>duplicatemarc("<?php echo $row[fid]; ?>","<?php echo $defaultindi1;?>","<?php echo $defaultindi2;?>","","no");<?php  
		}
	}  else {
		//echo "alert(\"$row[fid] $sourcecount\");";
	}
	?>	//-->
	</SCRIPT><?php  
	
																			
                                            }
                                    ?>
<?php  
if ($IDEDIT!="") {
?>
<TR bgcolor=white>
	<TD colspan=4>
	<?php echo getlang("ตัวเลือกการบันทึก::l::Save options"); ?> : 
	<LABEL><INPUT TYPE="radio" NAME="IDEDIT" value="<?php echo $IDEDIT?>" checked class=checkbox> <?php echo getlang("บันทึกรายการ::l::Save"); ?></LABEL>
	<LABEL><INPUT TYPE="radio" NAME="IDEDIT" value="" class=checkbox> <?php echo getlang("บันทึกเป็นรายการใหม่::l::Save as duplicate:"); ?></LABEL>
	</TD>
</TR>
<?php  
}
?>
                                    <tr bgcolor=white>
                                        <td colspan=5 align=center>
										<?php echo $lastbringmeto=sessionval_get("addauthority-bringmeto");?>
										<?php echo getlang("เสร็จแล้วไปที่::l::After saved go to"); ?> : 
										<LABEL><INPUT TYPE="radio" NAME="bringmeto" style="border-width:0" value="" <?php if ($lastbringmeto=="" && $chainid=='') { echo "checked";}?>> 
										<?php echo getlang("รายการวัสดุฯ::l::Material database"); ?></LABEL>  - 
										<?php if ($chn[name]!="") {?>
										<LABEL><INPUT TYPE="radio" NAME="bringmeto" style="border-width:0" value="backtochain" <?php if (($lastbringmeto=="" || $lastbringmeto=="backtochain") && $chainid!='') { echo "checked";}?>> 
										<?php echo getlang("กลับไป$chn[name]::l::Back to $chn[name]"); ?></LABEL>  - 
										<?php  }?>
										<LABEL><INPUT TYPE="radio" NAME="bringmeto" style="border-width:0" value="addnewrecord" <?php if ($lastbringmeto=="addnewrecord") { echo "checked";}?>>
										<?php echo getlang("เพิ่มรายการใหม่::l::Add another record"); ?></LABEL>
<BR>
                                            <input type = "submit" value = "Submit">
											<input type = "reset" value = "Reset"><font face = 'MS Sans Serif' size = 2>
											
                                            <div align = "center">
                                                <b><B><a href = "DBbook.php?sid=<?php echo $sid ?>&typeid=<?php echo $typeid ?>&faculty=<?php 
echo $faculty ?>&startrow=<?php 
echo $startrow ?>&linkfrom=<?php 
echo $IDEDIT ?>" class=a_btn>Back</a></B></b> 

</div>
                                        </td></tr>
                                </form>
                    </table>

					<table width = <?php echo $_TBWIDTH?> align = center border = 0 cellpadding = 3 cellspacing = 0 >
<TR>
	<TD>
	<FIELDSET>
<LEGEND style="color: #484F84"><B> <IMG SRC="maximize.png" WIDTH="12" HEIGHT="12" BORDER="1" style="border-color:#777777"> <?php echo getlang("แสดงแท็กเพิ่มเติม::l::More Tags"); ?> </B></LEGEND>
	 <?php  
$sql82="select * from bkedit_authority where  fid<>'$fixedwidthfield' and systemhide='no' order by ordr";
$result=tmq($sql82);
$prev1="0";
while ($row=tmq_fetch_array($result)) { 
		if (substr($row[fid],3,1)!="" && $prev1!=substr($row[fid],3,1)) {
			echo "<BR>";
		}
		$prev1=substr($row[fid],3,1);
		echo "<A HREF=\"javascript:void(0)\" id='link$row[fid]' ";
		if ($row[$USINGTEMPLATEFID]=='on' || trim($x[$row[fid]])!="")	 {
			echo " style='display: none;' ";
		} else {
			echo " style='display: inline;' ";
		}
		echo "onclick=\"document.all['tr$row[fid]'].style.display='block';this.style.display='none'\" title=\"$row[name]\">".str_replace("tag","",$row[fid])." </A>";
}
	?></FIELDSET></TD>
</TR>
</TABLE>
                    </td>
                    </tr>
                    </table>
<!--suggest me css & js start-->
<style type="text/css">

#fixedtipdiv{
position:absolute;
display:block;
padding: 2px;
border:1px solid black;
font:normal 12px Tahoma;
line-height:18px;
z-index:100;
}
#fixedtipdivforsuggest{
position:absolute;
padding: 2px;
border:1px solid black;
font:normal 12px Verdana;
line-height:18px;
z-index:100;
}

</style>
<script type="text/javascript">

/***********************************************
* Fixed ToolTip script- ? Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
		
var tipwidth='150px' //default tooltip width
var tipbgcolor='lightyellow'  //tooltip bgcolor
var disappeardelay=250  //tooltip disappear speed onMouseout (in miliseconds)
var vertical_offset="0px" //horizontal offset of tooltip from anchor link
var horizontal_offset="-3px" //horizontal offset of tooltip from anchor link

/////No further editting needed

if (ie4||ns6) {
	document.write('<div id="fixedtipdiv" style="visibility:hidden;width:'+tipwidth+';background-color:'+tipbgcolor+'" ></div>')
	document.write('<div id="fixedtipdivforsuggest" style="visibility:hidden;width:'+tipwidth+';background-color:'+tipbgcolor+'" ></div>')
}
function getposOffset(what, offsettype){
	var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
	var parentEl=what.offsetParent;
	while (parentEl!=null){
		totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
		parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}


function showhide(obj, e, visible, hidden, tipwidth,localdropmenuobj){
	if (ie4||ns6)
		localdropmenuobj.style.left=localdropmenuobj.style.top=-500
	if (tipwidth!=""){
		localdropmenuobj.widthobj=localdropmenuobj.style
		localdropmenuobj.widthobj.width=tipwidth
	}
	if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
		obj.visibility=visible
	else if (obj.visibility==hidden)
		obj.visibility=visible
	else if (obj.visibility==visible)
		obj.visibility=visible
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge, localdropmenuobj){
	var edgeoffset=(whichedge=="rightedge")? parseInt(horizontal_offset)*-1 : parseInt(vertical_offset)*-1
	if (whichedge=="rightedge"){
		var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
		localdropmenuobj.contentmeasure=localdropmenuobj.offsetWidth
		if (windowedge-localdropmenuobj.x < localdropmenuobj.contentmeasure)
			edgeoffset=localdropmenuobj.contentmeasure-obj.offsetWidth
	}
	else{
		var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
		localdropmenuobj.contentmeasure=localdropmenuobj.offsetHeight
		if (windowedge-localdropmenuobj.y < localdropmenuobj.contentmeasure)
		edgeoffset=localdropmenuobj.contentmeasure+obj.offsetHeight
	}
	return edgeoffset
}
function local_getPosition(obj){
    var topValue= 0,leftValue= 0;
    while(obj){
	leftValue+= obj.offsetLeft;
	topValue+= obj.offsetTop;
	obj= obj.offsetParent;
    }
    return topValue;
}
function fixedtooltip(menucontents, obj, e, tipwidth) {
	if (window.event) event.cancelBubble=true
	else if (e.stopPropagation) e.stopPropagation()
	clearhidetip()
	dropmenuobj=getobj("fixedtipdiv");
	//dropmenuobj=document.getElementById? document.getElementById("fixedtipdiv") : fixedtipdiv
	dropmenuobj.innerHTML=menucontents

	if (ie4||ns6) {
		showhide(dropmenuobj.style, e, "visible", "hidden", tipwidth,dropmenuobj)
		dropmenuobj.x=getposOffset(obj, "left")
		dropmenuobj.y=getposOffset(obj, "top")
		dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge",dropmenuobj)+"px"
		tmp=getobj('fixedtipdiv');
		//dropmenuobj.style.top=dropmenuobj.y+clearbrowseredge(obj, "bottomedge",dropmenuobj)+(obj.offsetHeight-tmp.clientHeight)+"px"//-tmp.clientHeight
		dropmenuobj.style.top=local_getPosition(obj)-tmp.clientHeight-5//+tmp.clientHeight-(local_getPosition(obj)+50)+"px"//-tmp.clientHeight
	}
}

function hidetip(e){
if (typeof dropmenuobj!="undefined"){
	if (ie4||ns6)
		dropmenuobj.style.visibility="hidden"
	}
}

function delayhidetip(){
	if (ie4||ns6)
	delayhide=setTimeout("hidetip()",disappeardelay)
}

function clearhidetip(){
if (typeof delayhide!="undefined")
clearTimeout(delayhide)
}

function showhidesuggestme_justhide() {
	dropmenuobjforsuggest=document.getElementById? document.getElementById("fixedtipdivforsuggest") : fixedtipdivforsuggest
	dropmenuobjforsuggest.innerHTML="";
	dropmenuobjforsuggest.style.visibility="hidden"
}

function fixedtooltipforsuggest(menucontents, obj, e, tipwidth,titletext) {
				 if (titletext==undefined) {
				 		titletext="<?php echo getlang("เครื่องมือช่วย::l::Related Data");?>";
				 } 
				 //alert(setlastfocusstr);
				 if (setlastfocusstr!="none") {
				  laststr=getobj(setlastfocusstr);
				  laststr=laststr.value;
				 }else {
				   laststr="";
				 }
				 //alert(laststr);
	//if (window.event) event.cancelBubble=true
	//else if (e.stopPropagation) e.stopPropagation()
	//clearhidetip()
	dropmenuobjforsuggest=document.getElementById? document.getElementById("fixedtipdivforsuggest") : fixedtipdivforsuggest
	dropmenuobjforsuggest.innerHTML="<TABLE width=100% class=table_border cellpadding=1 cellspacing=0><TR><TD class=table_head width=100%>"+titletext+"</TD><TD width=16 class=table_head style='cursor: hand; cursor: pointer;' ><B onmousedown='showhidesuggestme_justhide();'><img border=0 src='../neoimg/misc/DELETE.GIF'></B></TD></TR>"+
	"<TR>	<TD class=table_td colspan=2><iframe src='"+menucontents+"&laststr="+(laststr)+"' width=100% height=220 FRAMEBORDER='no' BORDER=0 SCROLLING=YES ></iframe></TD>	</TR></TABLE>";

	if (ie4||ns6) {
		showhide(dropmenuobjforsuggest.style, e, "visible", "hidden", tipwidth,dropmenuobjforsuggest)
		dropmenuobjforsuggest.x=getposOffset(obj, "left")
		dropmenuobjforsuggest.y=getposOffset(obj, "top")
		dropmenuobjforsuggest.style.left=dropmenuobjforsuggest.x-clearbrowseredge(obj, "rightedge",dropmenuobjforsuggest)+"px"
		dropmenuobjforsuggest.style.top=dropmenuobjforsuggest.y-clearbrowseredge(obj, "bottomedge",dropmenuobjforsuggest)+obj.offsetHeight+"px"
	}
}

</script>

<!--suggest me css & js end-->
					<?php  
					foot();?>