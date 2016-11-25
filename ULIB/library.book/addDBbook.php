<?php  
;
     include("../inc/config.inc.php");
	head();
	     include("addDBbook.inc.jshelp.php");

	?>
<style>
	.tagtr {
		border-color: #797979;
		border-style: solid;
		border-width: 0px;
		border-top-width: 0px;
		border-left-width: 0px;
	}
	.localbookinput {
		border-width: 0px;
	}


.tooltipxx {
	display: none;
    background-color: #ffffff!important;;
    border: 1px solid #73a7f0;
    width: 320px;
    height: auto;
    margin-left: 32px;
    position:absolute;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    box-shadow: 0px 0px 8px -1px black;
    -moz-box-shadow: 0px 0px 8px -1px black;
    -webkit-box-shadow: 0px 0px 8px -1px black;
    z-index: 5000;
}

.tooltipxx p {
    padding:10px;
	height: auto;
}

.tooltipxxShadow {
    background-color: transparent;
    width: 4px;
    height: 4px;
    position: absolute;
    top: 16px;
    left: -8px;
    z-index: -10;
    box-shadow: 0px 0px 8px 1px black;
    -moz-box-shadow: 0px 0px 8px 1px black;
    -webkit-box-shadow: 0px 0px 8px 1px black;
}

.tooltipxxtail1 {
    width: 0px;
    height: 0px;
    border: 10px solid;
    border-color: transparent #73a7f0 transparent transparent;
    position:absolute;
    top: 8px;
    left: -20px;
}

.tooltipxxtail2 {
    width: 0px;
    height: 0px;
    border: 10px solid;
    border-color: transparent #ffffff transparent transparent;
    position:absolute;
    left: -18px;
    top: 8px;
}
	</style>
	<?php  
	include("_REQPERM.php");
	//prepare authority
	$as=tmq("select * from authoritydb_rule");
	$adb=Array();
	while ($asr=tmq_fetch_array($as)) {
		$keys=explode(',',$asr[workonmarctag]);
		while (list($k,$v)=each($keys)) {
			$adb["$v"]="yes";
		}
	}
	$librarian_autotagid=getval("MARC","librarian_tagname");
	$helpsuggeststr_dc=getval("MARC","dc_tagname");
	$helpsuggeststr_lc=getval("MARC","lc_tagname");
	$helpsuggeststr_nlm=getval("stat","nlm_tagname");
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
					$thisjsid="indi_".randid();
					echo "<SELECT NAME='$formname' ID='$formname' style='-webkit-appearance: none; padding-left:2px; padding-right: 2px;; -moz-appearance: none;   appearance: none;   border: 1px outset #E7E7E7 ; margin-left: 2px;;   background: transparent;'>";
					echo "<option selected style='background-color: #F0F9E8' value='$current'>$current</option>";
					foreach ($defindi1 as $defindi1i) {
						echo "<option value='$defindi1i'>$defindi1i</option>";
					}
					echo "</SELECT>";
					return $thisjsid;
	}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--

	function FitToContent(text,helpsetautoarticle)
{
   //var text = getobj(id);
	if ( !text ) return;
	//alert(1);
	maxHeight=500
	var adjustedHeight = text.clientHeight;
	//alert(adjustedHeight);
	if ( !maxHeight || maxHeight > adjustedHeight ) {
		adjustedHeight = Math.max(text.scrollHeight, adjustedHeight);
		if ( maxHeight ) 
		adjustedHeight = Math.min(maxHeight, adjustedHeight);
		//alert(" "+adjustedHeight +"--"+ text.clientHeight);
		if ( adjustedHeight > text.clientHeight ) {
		  tmpaddheight=getobj(text.id+"_sftop");
		  if (typeof tmpaddheight!= undefined) {
			tmpaddheight.style.height = adjustedHeight + "px";
		  }
			text.style.height = adjustedHeight + "px";
			//alert(text.style.height);
		}
	}
	if (helpsetautoarticle!="none" && helpsetautoarticle!="" && helpsetautoarticle!=undefined) {
	  tmp=text.value+"";
	  tmp2=tmp.substring(0,2);
	  tmp3=tmp.substring(0,3);
	  tmp4=tmp.substring(0,4);
	  //alert(tmp2);
      helpsetautoarticleobj=getobj(helpsetautoarticle);
      if (helpsetautoarticleobj.length>7 && (tmp2=="a " || tmp2=="A ")) {
         helpsetautoarticleobjselectedIndex = 2;
         for(var helpsetautoarticleobjsubi=0; helpsetautoarticleobjsubi < helpsetautoarticleobj.length -1 ; helpsetautoarticleobjsubi++) {
            if(helpsetautoarticleobjselectedIndex == helpsetautoarticleobj.options[helpsetautoarticleobjsubi].value) {
               helpsetautoarticleobj.selectedIndex = helpsetautoarticleobjsubi;
            }
         }
      }
      if (helpsetautoarticleobj.length>7 && (tmp3=="an " || tmp3=="An "|| tmp3=="AN "|| tmp3=="le "|| tmp3=="Le "|| tmp3=="LE "|| tmp3=="la "|| tmp3=="La "|| tmp3=="LA "|| tmp3=="un "|| tmp3=="Un "|| tmp3=="UN " )) {
         helpsetautoarticleobjselectedIndex = 3;
         for(var helpsetautoarticleobjsubi=0; helpsetautoarticleobjsubi < helpsetautoarticleobj.length -1 ; helpsetautoarticleobjsubi++) {
            if(helpsetautoarticleobjselectedIndex == helpsetautoarticleobj.options[helpsetautoarticleobjsubi].value) {
               helpsetautoarticleobj.selectedIndex = helpsetautoarticleobjsubi;
            }
         }
      }
      //console.log(tmp4);
      if (helpsetautoarticleobj.length>7 && (tmp4=="the " || tmp4=="The " || tmp4=="THE "|| tmp4=="les "|| tmp4=="Les "|| tmp4=="LES " || tmp4=="une "|| tmp4=="Une "|| tmp4=="UNE " || tmp4=="des "|| tmp4=="Des "|| tmp4=="DES " )) {
         
         helpsetautoarticleobjselectedIndex = 4;
         for(var helpsetautoarticleobjsubi=0; helpsetautoarticleobjsubi < helpsetautoarticleobj.length -1 ; helpsetautoarticleobjsubi++) {
            //console.log("walk"+helpsetautoarticleobjsubi+"="+helpsetautoarticleobj.options[helpsetautoarticleobjsubi].value);
            if(helpsetautoarticleobjselectedIndex == helpsetautoarticleobj.options[helpsetautoarticleobjsubi].value) {
               helpsetautoarticleobj.selectedIndex = helpsetautoarticleobjsubi;
            }
         }
      }
	}
}



function localbookinputkeydown(event,fid,i1,i2,defval) {
	//enter backspace delete
	if (event.keyCode==13 ) {
		if (fid!="") {
			duplicatemarc(fid,i1,i2,defval);
		}
		return false;
	}
	return true;
}

taglistiscanrepeat=Array();

KB_CTRL_Rdb=Array();
var isCtrlKBPressed = false;
var isShiftKBPressed = false;
var isAltKBPressed = false;
document.onkeyup=function(e) {
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	if(keycode == 17) isCtrlKBPressed=false;
    if(keycode == 16) isShiftKBPressed=false;
    if(keycode == 18) isAltKBPressed=false;
}
document.onkeydown=function(e){
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
    if(keycode == 17) isCtrlKBPressed=true;
    if(keycode == 16) isShiftKBPressed=true;
    if(keycode == 16) isAltKBPressed=true;
	if(isAltKBPressed==true && isShiftKBPressed == true && isCtrlKBPressed == true && keycode == 107) { // ctrl shift +
		addtagbykeyboard();
      isCtrlKBPressed=false;
      isShiftKBPressed=false;
      isAltKBPressed=false;
		return true;
	}
	if(isAltKBPressed==true && isShiftKBPressed == true && isCtrlKBPressed == true && setlastfocusstr!="none") {
		if((keycode >= 65 && keycode <=90) || (keycode >= 48 && keycode <=57)) {
			 tmp=getobj(setlastfocusstr); tmps=tmp.value=tmp.value+'^'+String.fromCharCode(keycode).toLowerCase();
		}
		return false;
	}
    if(keycode == 82 && isCtrlKBPressed == true) {
		//ctrl+R
         eval(KB_CTRL_Rdb[setlastfocusstr_tag]);
         return false;
    }
    if(keycode == 83 && isCtrlKBPressed == true) {
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
var clonestr;
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

function escapeRegExp(string) {
    return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}
function replaceAll(string, find, replace) {
  return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}
function localhilightsubfields(wh,tag) {
   tmp1=getobj(wh);
   tmp2=getobj(wh+"_sf");
   tmpsfinfo="";
   //alert(tag);
   if (typeof getlocalvalidtagv[tag]=="undefined") {
      tmp2.innerHTML=replaceAll(tmp1.value,"^","<font style='background-color: #DDE6EF; color: #DDE6EF'>^</font>");
   } else {
      sflist=getlocalvalidtagv[tag].split(",");
      var arrayLength = sflist.length;
      tmpres=replaceAll(tmp1.value,"^","[[[-]]]");
      //console.log(sflist);
      for (var i = 0; i < arrayLength; i++) {
          tmpres=replaceAll(tmpres,"[[[-]]]"+sflist[i],"<font style='background-color: #DDE6EF; color: #DDE6EF'>^"+sflist[i]+"</font>");
      }
      tmpres=replaceAll(tmpres,"[[[-]]]","<font style='background-color: #EFCEC7; color: #EFCEC7'>^</font>");

      tmp2.innerHTML=tmpres;
   }

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
function removemarcbytag(wh) {
	//alert(wh);
	try {
		getobj("result_"+wh).innerHTML="";
	}
	catch(err)
	  {
		//alert("removemarcbytag() error: " + wh);
		return;
	  //Handle errors here
	  }	
}
function addtagbykeyboard() {
	tagneeded=prompt("<?php echo getlang("กรุณากรอกรหัสเลขแท็ก. (เช่น. 246) แล้วคลิก OK หรือกดคีย์บอร์ด enter::l::Please choose tag id. (ie. 246) and click ok or press enter");?>");
	//alert(tagneeded);
	try {
	tmp=getobj('trtag'+tagneeded); 
	tmp.style.display='block';
	tmp.style.height='auto';
	  }
	catch(err)
	  {
		alert('tag not found');
	  }
	//duplicatemarc(fid," "," ","");
   return true;
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
	}*/
	if (wh=='<?php echo $librarian_autotagid; ?>') {
		if (after2=="") {
			 after2="^a<?php echo get_library_name($useradminid)?>";
		}
	}
	//alert(document.all["source_"+wh].innerHTML);
try {
	newhtml=getobj("source_"+wh).innerHTML;
  }
catch(err)
  {
	///alert("duplicatemarc() error:" + wh);
	return;
  //Handle errors here
  }
		tmpcb=document.getElementsByName("data["+wh+"][]");
		tmpcbi1=document.getElementsByName("dataindi1["+wh+"][]");

		//return;
		tmpcbi2=document.getElementsByName("dataindi2["+wh+"][]");
		//alert(getobj("result_"+wh).innerHTML);
		var savemode=Array();
		var savemodei1=Array();
		var savemodei2=Array();
		//alert(typeof tmpcbi1[0]);
		//alert(tmpcb.length);
		for (tmpcbx = 0; tmpcbx<tmpcb.length; tmpcbx++) {
			if (typeof tmpcbi1[0]!="undefined") {
				savemodei1[tmpcbx]=tmpcbi1[tmpcbx].selectedIndex
				savemodei2[tmpcbx]=tmpcbi2[tmpcbx].selectedIndex
			}
			savemode[tmpcbx]=tmpcb[tmpcbx].value
			//alert(tmpcb[tmpcbx].value); 
			//alert(savemode[tmpcbx]); 
		}
	newhtml="<span ID='[RANDOMHERE]' style='display:block;'>"+newhtml+"  <div style='display:inline-block;'>";
	if (isdelable!='no')	{
		newhtml=" "+newhtml+" <B onclick=\"removemarc('[RANDOMHERE]')\"> <IMG SRC='../neoimg/red.gif' WIDTH=21 HEIGHT=21 BORDER=0 ></B><BR>";
	} else {
		newhtml=" "+newhtml+"  <IMG SRC='../neoimg/red-dis.gif' WIDTH=21 HEIGHT=21 BORDER=0 ><BR>";
	}
	newhtml="</div>"+newhtml+"</span>"
	newid=Math.floor(Math.random()*1000000);
	newid="NEWITEM"+newid;
	//after2=addslashes(after2);

	tagpureid=Math.floor(wh.substring(3));
	for (tmpruni = 0; tmpruni<25; tmpruni++) {

   	newhtml=newhtml.replace("[TAGPUREID]",tagpureid);
   	newhtml=newhtml.replace("[CONTROLTAGNAME]",wh);
   	newhtml=newhtml.replace("[RANDOMHERE]",newid);	
   	newhtml=newhtml.replace("[CHOOSENINDI1]",indi1);
   	newhtml=newhtml.replace("[CHOOSENINDI2]",indi2);

   	if (ie==1) {
   		newhtml=newhtml.replace("[INPUTEDDATA]","\""+after2+"\"");
   	} else {
   		newhtml=newhtml.replace("[INPUTEDDATA]",""+after2+"");		
   	}
   }

	getobj("result_"+wh).innerHTML=getobj("result_"+wh).innerHTML+newhtml;
	//alert(after2);
	//
	/*
	if (wh=='tag245') {
		alert(newhtml);
	}*/
	for (tmpcbx = 0; tmpcbx<tmpcb.length; tmpcbx++) {
		if (typeof savemode[tmpcbx]!="undefined") {
			tmpcb[tmpcbx].value=savemode[tmpcbx];
			//alert(tmpcbi1[tmpcbx]);
		}
		//	alert(tmpcbi1[tmpcbx]);
		if (typeof tmpcbi1[tmpcbx]!="undefined") {
			tmpcbi1[tmpcbx].selectedIndex=savemodei1[tmpcbx];
		}
		if (typeof tmpcbi2[tmpcbx]!="undefined") {
			tmpcbi2[tmpcbx].selectedIndex=savemodei2[tmpcbx];
		}
	}
	/*if (wh=='tag245') {
		alert(savemode[tmpcbx]);
	}*/
	//focusit
	tmp=getobj("data"+newid+"");
	FitToContent(tmp)
	tmp.focus();
	return newid;
}
//-->
</SCRIPT>
<!-- preload area -->
<IMG SRC="../neoimg/minus.gif" WIDTH="1" HEIGHT="1" BORDER="0" ALT="" style="display:none">
<IMG SRC="../neoimg/plus.gif" WIDTH="1" HEIGHT="1" BORDER="0" ALT="" style="display:none">
<IMG SRC="../neoimg/red.gif" WIDTH="1" HEIGHT="1" BORDER="0" ALT="" style="display:none">
<IMG SRC="../neoimg/red-dis.gif" WIDTH="1" HEIGHT="1" BORDER="0" ALT="" style="display:none">

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
<INPUT TYPE = "hidden" name = "acqxlsref" value = "<?php echo $loadacqxls; ?>">
<INPUT TYPE = "hidden" name = "forcebringmeto" value = "<?php echo $forcebringmeto; ?>">
<INPUT TYPE = "hidden" name = "startrow" value = "<?php echo $startrow; ?>">
<INPUT TYPE = "hidden" name = "chainmaster" value = "<?php echo $chainmaster; ?>">
<INPUT TYPE = "hidden" name = "chainid" value = "<?php echo $chainid; ?>">
<?php  
if ($chainid!="" && $chainmaster!="") {
	?>	<TABLE cellspacing=0 cellpadding=2 align=center class=table_border width=600>
	<TR>
	<TD colspan=9 class=table_head2 style="font-size: 20;"><?php  
	$chn=tmq("select * from chainer where code='$chainid' ");
	$chn=tmq_fetch_array($chn);
	if ($chn[code]=="journalindex" && $USINGTEMPLATE=="") {
		$chntemplate=tmq("select * from marc_template where forjindex='yes' ");
		$chntemplate=tmq_fetch_array($chntemplate);
		$USINGTEMPLATE=$chntemplate[id];
		$USINGTEMPLATE_autosetleader07=$chntemplate[autoset];
	}
	$chn[name]=getlang($chn[name]);
	$chn[desttxt]=getlang($chn[desttxt]);
	$chn[word]=getlang($chn[word]);
	echo getlang($chn[name]);
	if ($IDEDIT!="") {
		$chnlink=tmq("select * from chainerlink where chain='$chainid'
		and fromid='$chainmaster' and destid='$IDEDIT' ");
		$chnlink=tmq_fetch_array($chnlink);
		//printr($chnlink);
	}
	$chnlink[frommid]=floor($chnlink[frommid]);
	?> 
	:: <A HREF="../library.chainer/items.php?chainid=<?php echo $chainid?>&chainmaster=<?php echo $chainmaster?>"><?php echo getlang("กลับ::l::Back");?></A>
	</TD>
	</TR>
	<TR>
	<TD colspan=9 class=table_head2 style="text-align: left;">
	<?php echo $chn[desttxt];?>	
	<A HREF="../dublin.php?ID=<?php echo $chainmaster?>" target=_blank><?php  
	echo marc_gettitle($chainmaster);				
	?></A><?php  
	if ($chn[usemid]=="yes") {
		?><BR>
		<SELECT NAME="chainfrommid" ID="chainfrommid" onchange="setyearbychainid(); return true;">
		<?php  
		if ($chnlink[frommid]!=0) {
			$chnlink_tmpinf=tmq("select * from media_mid where id='$chnlink[frommid]' ");
			if (tmq_num_rows($chnlink_tmpinf)!=0) {
				$chnlink_tmpinf=tmq_fetch_array($chnlink_tmpinf);
				echo "<OPTION VALUE='$chnlink[frommid]' SELECTED style='background-color: #FF9999'>".marc_getserialcalln($chnlink[frommid])."</OPTION>";
			}
		}
		$chnlinkitems=tmq("SELECT *  FROM media_mid where pid='$chainmaster' order by inumber,jenum_1,jenum_2,jenum_3,jenum_4,jenum_5,jenum_6,jchrono_1,jchrono_2,jchrono_3,id");
		while ($chnlinkitemsr=tmq_fetch_array($chnlinkitems)) {
			echo "<OPTION VALUE='$chnlinkitemsr[id]'>$chnlinkitemsr[bcode]:"
			.marc_getserialcalln($chnlinkitemsr[id])."</OPTION>";
		}
		?>
			
			
		</SELECT><FONT class=smaller2><BR>

		
		 &nbsp;&nbsp;&nbsp;&nbsp;<?php echo getlang("กรอง::l::Filter");?>: </FONT><INPUT NAME=regexp onKeyUp="myfilter.set(this.value)" class=smaller>
<SCRIPT LANGUAGE="JavaScript" src="../js/filterlist.js">
<!--
	
//-->
</SCRIPT>
<SCRIPT TYPE="text/javascript">
<!--
var myfilter = new filterlist(document.forms["FaddDBbook"]["chainfrommid"]);
//-->
</SCRIPT>
<?php  

	}
	?></TD>
	</TR>
	</TABLE><BR>
<?php  
}
?><table cellpadding=0 cellspacing=0 align=center width="<?php echo $_TBWIDTH;?>">
<tr>
	<td><?php  
if ($IDEDIT!="") {
  
  html_label('b',$IDEDIT);
	$x="select * from media where ID='$IDEDIT' ";
	$x=tmq($x);
	if (tnr($x)!=1) {
		 html_dialog("","Error ผิดพลาด ไม่พบรายการที่ต้องการแก้ไข");
		 foot();
		 die;
	}
	//chk lock bib s
	$now=time();
	$timeold=$now-(60*30*1);
	tmq("delete from lock_bib where dt<$timeold");
	$chkbiblock=tmq("select * from lock_bib where bibid='$IDEDIT' and not loginid='$useradminid' ");
	if (floor(tnr($chkbiblock))!=0) {
	  $chkbiblock=tfa($chkbiblock);
		 html_dialog("","ไม่อนุญาต<BR>
		 รายการนี้ถูกล็อคไว้ เนื่องจากกำลังถูกแก้ไข <BR>โดย ". 
		 get_library_name($chkbiblock[loginid]) . " เมื่อ ".ymd_datestr($chkbiblock[dt]));
		 if (library_gotpermission("lockedbib")) {
		    ?><center><a href="<?php echo $dcrURL;?>library.lockedbib/">Manage</a></center><?php
		 }
		 foot();
		 die;
	} else {
	  tmq("delete from lock_bib where bibid='$IDEDIT'");
	  tmq("insert into lock_bib set bibid='$IDEDIT', loginid='$useradminid',dt='$now'  ");
	}
	
	//chk lock bib e
	
	$x=tmq_fetch_array($x);

	if ($x[LIBSITE]=="") {
		$x[LIBSITE]=$LIBSITE;
		tmq("update media set LIBSITE='$LIBSITE' where ID='$IDEDIT'  ",false);
	}

  if ($x[LIBSITE]!=$LIBSITE && getlibsitebibrule($LIBSITE,$x[LIBSITE],"permission-edit")!="yes") {
	html_dialog("Error!",getlang("คุณไม่มีสิทธิ์แก้ไข Bib นี้::l::You have no permission to edit this Bib. "));	
	die;
  }

}
?></td>
	<td width=50% align=right><?php  
	if (floor($IDEDIT)!=0) {
		viewdiffman("bib","$IDEDIT");
	}
	?>
	<a href="javascript:void(null);" class="smaller a_btn" onclick="tmp=getobj('mergemarcdiv'); tmp.style.display='block';;"><?php echo getlang("วางมาร์ค::l::Paste MARC");?></a>
<?php  
addons_module("library_book_adddbddal_module");
?>	
	</td>
</tr>
</table>

<?php  
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
   if ($noformat=="yes") {
      $noformatdb=tmq_dump2("marc_noformat","id","kw");
      $noformatdbtag=tmq_dump2("marc_noformat","id","desttag");
      $noformatdbtp=tmq_dump2("marc_noformat","id","tp");
      //printr($noformatdb);
      @reset($noformatdb);
      while (list($noformatdbk,$noformatdbv)=each($noformatdb)) {
         $noformatdbv=str_replace("[tab]","	",$noformatdbv);
         $noformatdbv=str_replace("[tab]","	",$noformatdbv);
         $noformatdbv=str_replace("[tab]","	",$noformatdbv);
         $noformatdbv=str_replace("[tab]","	",$noformatdbv);
         $noformatdbv=str_replace("[tab]","	",$noformatdbv);
         $noformatdbv=str_replace("[tab]","	",$noformatdbv);
         $noformatdbva=explodenewline($noformatdbv);
         $noformatdbva=array_unique($noformatdbva);
         $noformatdbva=arr_filter_remnull($noformatdbva);
         $newscannedarray=Array();
         while (list($noformatdbvak,$noformatdbvav)=each($noformatdbva)) {
            if (substr($noformatdbvav,-1)=="|") {
               $newscannedarray[]=substr($noformatdbvav,0,-1)."	";
               $newscannedarray[]=substr($noformatdbvav,0,-1).":";
               $newscannedarray[]=substr($noformatdbvav,0,-1)." :";
               $newscannedarray[]=substr($noformatdbvav,0,-1)." 	";
               $newscannedarray[]=substr($noformatdbvav,0,-1)." :";
            } else {
               $newscannedarray[]=$noformatdbvav;
            }
         }
         $noformatdb[$noformatdbk]=$newscannedarray;
      }
      //printr($noformatdb);
     	$THEMARC=stripslashes($THEMARC);
     	$THEMARC=explodenewline($THEMARC);
    	$lastyaztag="";
    	@reset($THEMARC);
      $finishthisrow=false;
    	while (list($yazkey,$yazvalue)=each($THEMARC)) {
         $finishthisrow=false;
         $yazvalue=trim($yazvalue);
         //echo "<hr> . scanning for $yazvalue;<BR>";
         @reset($noformatdb);         
         while ($finishthisrow==false && list($noformatdbk,$noformatdbv)=each($noformatdb)) {
            $noformatdbkorig=$noformatdbk;
            $noformatdbk=$noformatdbtag[$noformatdbk];
            //echo "scanning for tag $noformatdbk<BR>";
            //$noformatdbv=str_replace("[tab]","	",$noformatdbv);
            //$noformatdbv=str_replace("[tab]","	",$noformatdbv);
            //$noformatdbv=str_replace("[tab]","	",$noformatdbv);
            //$noformatdbv=str_replace("[tab]","	",$noformatdbv);
            //$noformatdbv=str_replace("[tab]","	",$noformatdbv);
            //$noformatdbvkw=explodenewline($noformatdbv);
   			//$noformatdbvkw=arr_filter_remnull($noformatdbvkw);
   			$noformatdbvkw=($noformatdbv);
            @reset($noformatdbvkw);
            $foundsome=false;
            while (list($noformatdbvkwk,$noformatdbvkwv)=each($noformatdbvkw)) {
               if (trim($noformatdbvkwv)=="") continue;
               //echo " - - check for <u>[$noformatdbvkwv] in $yazvalue</u><BR>";
               if ( $foundsome==false && substr($yazvalue,0,strlen($noformatdbvkwv))==$noformatdbvkwv) {
                  $foundsome=true;
                  $finishthisrow=true;
                  //echo " - - - <b>found $noformatdbvkwv</b><BR>";
                  $strtoadd=substr($yazvalue,strlen($noformatdbvkwv));
                  $strtoadd=trim($strtoadd," \\\"'.,;:-+*/");
                  //$strtoadd=addslashes($strtoadd);
                  $strtoadd=str_replace("[data]",$strtoadd,$noformatdbtp[$noformatdbkorig]);
                  $x["tag".$noformatdbk]=$x["tag".$noformatdbk].$newline.$strtoadd;
                  $lastyaztag=$noformatdbk;
                  $lastyaztagorig=$noformatdbkorig;
               }
            }
          }
          if ($finishthisrow==false) {
            //echo " unfinished;";
          }
           if ($finishthisrow==false && trim($lastyaztag)!="" && floor($lastyaztag)>0) { // add to last found tag
               //echo "here $finishthisrow - $lastyaztag =$yazvalue<BR>";
               $strtoadd=$yazvalue;
               $strtoadd=str_replace("[data]",$strtoadd,$noformatdbtp[$lastyaztagorig]);
               $strtoadd=trim($strtoadd,"\\\"'.,;:-+*/");
               //$strtoadd=addslashes($strtoadd);
               if ($strtoadd!="") {
                  $x["tag".$lastyaztag]=$x["tag".$lastyaztag].$newline.$strtoadd;
                  //echo " - - - adding from LASTyaztag [$lastyaztag] +=$strtoadd<BR>";
               }
            }
            if ($x["tag".$noformatdbk]!="") {
               $x["tag".$noformatdbk]=trim($x["tag".$noformatdbk],$newline);
            }
    	}
    	//printr($THEMARC);printr($x);
      //die("Processing no format");
  } else {
          
    	//echo $THEMARC;
    	$THEMARC=explodenewline($THEMARC);
    	//printr($THEMARC);
    	$_STR_A_Za=explode(',',$_STR_A_Z);
    	$lastyaztag="";
    	foreach ($THEMARC as $yazvalue) {
    		$yazvalue=rtrim($yazvalue);
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
    		$tagbody=substr($yazvalue,7);
    		$yazstr=substr($yazvalue,4,2).($tagbody);
    		$yazstr=str_replace("	"," ",$yazstr);
    		$yazstr=str_replace('$',"^",$yazstr);
    		$yazstr=str_replace('#',"^",$yazstr);
    		$yazstr=str_replace('|',"^",$yazstr);
    		$yazstr=str_replace('\\',"^",$yazstr);
    		$yazstr=str_replace('\t',"^",$yazstr);
    		$yazstr=str_replace('\r',"^",$yazstr);
    		$yazstr=str_replace('^^',"^",$yazstr);
    		$yazstr=removenewline($yazstr);
    		reset($_STR_A_Za);
    		while (list($azk,$azv)=each($_STR_A_Za)) {
    			$yazstr=str_replace("   ^a","  ^a",$yazstr);
    			$yazstr=str_replace("^$azv ","^$azv",$yazstr);
    		}
    		$x[$yazdec]=$x[$yazdec].$newline.$yazstr;
    		$x[$yazdec]=trim($x[$yazdec],$newline);
    		$x[$yazdec]=rtrim($x[$yazdec]);
    		$x[$yazdec]=stripslashes($x[$yazdec]);
    		if ($yazdec=="$fixedwidthfield") {
    			$chkfwdat=trim($x[$yazdec]);
    			//echo "------------$fixedwidthfield-".$x[$yazdec]."-".strlen($chkfwdat);
    			if (strlen($chkfwdat)==40) {
    				$fwdat=$chkfwdat;
    			}
    		} elseif (strtoupper($yazdec)=="TAGLEA" || strtoupper($yazdec)=="TAGLDR") {
    			$chkLEADER=trim(substr($x[$yazdec],2));
    			//echo "------------$yazdec-".$x[$yazdec].".>$chkLEADER-".strlen($chkLEADER);
    			if (strlen($chkLEADER)==24) {
    				$LEADER=$chkLEADER;
    			}
    		} else {
    			$subtaglist=explodenewline($x[$yazdec]);
    			$subtaglist=arr_filter_remnull($subtaglist);
    			$subtagres="";
    			while (list($subtaglistk,$subtaglistv)=each($subtaglist)) {
    				$subfieldapos = strpos($subtaglistv, '^a');
    				if ($subfieldapos === false) {
    					$subtagres.=substr($subtaglistv,0,2)."^a".substr($subtaglistv,2).$newline;
    				} else {
    					$subtagres.=$subtaglistv.$newline;
    				}
    			}
    			$x[$yazdec]=rtrim($subtagres);
    		}
    	}
   }
} //($usethemarc=="yes") 

function local_fwi($txt,$inputname,$s,$length,$default,$isfocus="no") {
	global $fwdat;
	global $_MSTARTY;
	global $_MENDY;
	$txts=explode(":",$txt);
	$alert=$txts[1];
	$alertorig=$txts[0]."&".$txts[1];
	$randid=randid();
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
	ID='<?php  echo $randid;?>'
	maxlength=<?php  echo $length;?>
	onfocus="tmp=getobj('<?php  echo $randid;?>TT');tmp.style.display='inline-block';;this.select()" <?php  
	if ($isfocus!="no") {
		 ?> style='border-color: #FF0000; border-width: 1px;border-style: solid; background: white; background-image:none; ' <?php  
	} else {
	     ?> style="background: white; background-image:none;" <?php
	}
	?>
	onblur="setTimeout('timeouthidetooltip<?php  echo $randid;?>()',200);;chkleng(this,<?php  echo $length;?>)"
	> 
	<div class="tooltipxx" ID="<?php  echo $randid;?>TT" style="z-index:100000">
    <p style="padding-top: 0px;"><?php  
			$al=explode("&",$alertorig);
			@reset($al);
			list($k,$v)=each($al);
			list($k2,$v2)=each($al);
			list($k3,$v3)=each($al);
			echo "<b>$v</b> $v2 $v3<br>";
			if ($v=="Date 1" || $v=="Date 2") {
				for ($i=$_MSTARTY;$i<=$_MENDY;$i++) {
					?><a href="javascript:void(null);" onclick="tmp=getobj('<?php  echo $randid;?>');tmp.value='<?php echo $i?>';tmp=getobj('<?php  echo $randid;?>TT');tmp.style.display='none';"><b><?php echo $i;?></b></a> <?php  
				}
				echo "<br>";
				for ($i=$_MSTARTY-543;$i<=$_MENDY-543;$i++) {
					?><a href="javascript:void(null);" onclick="tmp=getobj('<?php  echo $randid;?>');tmp.value='<?php echo $i?>';tmp=getobj('<?php  echo $randid;?>TT');tmp.style.display='none';"><b><?php echo $i;?></b></a> <?php  
				}
			}
			while (list($k,$v)=each($al)) {
				$va=explode("-",$v);
				$va[0]=trim($va[0]);
				?><a href="javascript:void(null);" onclick="tmp=getobj('<?php  echo $randid;?>');tmp.value='<?php echo $va[0]?>';tmp=getobj('<?php  echo $randid;?>TT');tmp.style.display='none';"><b><?php echo $va[0];?></b> - <?php echo $va[1];?></a><br><?php  
			}
			 ?></p>
    <div class="tooltipxxtailShadow"></div>
    <div class="tooltipxxtail1"></div>
    <div class="tooltipxxtail2"></div>
</div>
<script type="text/javascript">
<!--
	function timeouthidetooltip<?php  echo $randid;?>() {
			 tmp=getobj("<?php  echo $randid;?>TT");
			 tmp.style.display="none";;
	}
//-->
</script><?php  
	return $randid;
}

function local_ldi($txt,$inputname,$s,$length,$default,$ishide=false,$setval="",$isfocus="no") {
	global $LEADER;
	$randid="local_ldi".$inputname;//.randid();
	//echo "[$setval]";
	$txts=explode(":",$txt);
	$alert=$txts[1];
	$txt=$txts[0];
	echo "<label ID='leaderlabel$inputname'><font class=smaller>$txt</font>";
	$alertorig="$alert";
	if ($alert!="" && $ishide!=false) {
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
		ID='<?php  echo $randid;?>'
		onfocus="tmp=getobj('<?php  echo $randid;?>TT');tmp.style.display='inline-block';;this.select()"
		onblur="setTimeout('timeouthidetooltip<?php  echo $randid;?>()',200);return chkleng(this,<?php  echo $length;?>)"
			<?php  	if ($isfocus!="no") {
			 ?> style='border-color: #FF0000; border-width: 1px; border-style: solid; background: white; background-image:none; ' <?php  
		 } else {
			 ?> style=' background: white; background-image:none; ' <?php  
		 }?>
		> </label><div class="tooltipxx" ID="<?php  echo $randid;?>TT">
    <p style="padding-top: 0px;"><?php  
			$al=explode("&",$alertorig);
			@reset($al);
			list($k,$v)=each($al);
			echo "<b>$v</b><br>";
			while (list($k,$v)=each($al)) {
				$va=explode("-",$v);
				$va[0]=trim($va[0]);
				?><a href="javascript:void(null);" onclick="tmp=getobj('<?php  echo $randid;?>');tmp.value='<?php echo $va[0]?>';tmp=getobj('<?php  echo $randid;?>TT');tmp.style.display='none';"><b><?php echo $va[0];?></b> - <?php echo $va[1];?></a><br><?php  
			}
			 ?></p>
    <div class="tooltipxxtailShadow"></div>
    <div class="tooltipxxtail1"></div>
    <div class="tooltipxxtail2"></div>
</div>
<script type="text/javascript">
<!--
	function timeouthidetooltip<?php  echo $randid;?>() {
			 tmp=getobj("<?php  echo $randid;?>TT");
			 tmp.style.display="none";;
	}
//-->
</script>
		<?php  
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
<TABLE cellpadding=2 cellspacing=0 border=0 width=780 align=center>
<TR>
	<TD><A HREF="javascript:void(null);" onclick="tmp=getobj('SETCOLLECTION'); tmp.style.display='inline'" style="font-size:13; color:black; text-decoration:none;">Collections:</A>
<div style="display:none;" ID="SETCOLLECTION"><?php  

$collections=tmq("select * from collections order by name");
$i=0;
$all=tmq_num_rows($collections);
while ($collectionsr=tmq_fetch_array($collections)) {
	$i++;
?><nobr><label><?php  
	echo "<img src='$dcrURL/neoimg/collectionicon/$collectionsr[icon]' width=24 height=24 align=absbottom>";

?><INPUT TYPE="checkbox" NAME="collist[<?php  echo $collectionsr[id]?>]" value="<?php  echo $collectionsr[classid]?>" style="border-width: 0;"
<?php  
$collectionchk = @strpos($x[collist], $collectionsr[classid]);
//echo "[strpos($x[collist], $collectionsr[classid]);]";
if ($collectionchk === false) {
} else {
	echo " checked ";
}	
?>>
	<font style='font-size: 14px; ' ><?php echo getlang($collectionsr[name])?></font></label></nobr> 
<?php  
	if ($i<$all) {
		echo "&nbsp;<B>:</B>&nbsp;";
	}
}	?></div></TD>
</TR>
</TABLE>
<TABLE border=0 width=780 align=center cellspacing=0 cellpadding=3 class=table_border>
<TR>
	<TD class=table_td > <B>&nbsp;Marc Templates:</B>
	<?php  
		if ($USINGTEMPLATE=="") {
			$tmptpd=substr($LEADER,7,1);
			if ($tmptpd=="" && $IDEDIT!="") {
				echo("Leader/07 ผิดพลาด!");
			} else {
				$tmptpd_len=strlen(trim($tmptpd));
				$tmptpd=tmq("select * from marc_template where autoset='$tmptpd' ");
				if (tmq_num_rows($tmptpd)!=0 && $tmptpd_len!=0) {
					//echo "1-$tmptpd_len";
					$tmptpd=tmq_fetch_array($tmptpd);
					//print_r($tmptpd);
					$USINGTEMPLATE=$tmptpd[id];
					$USINGTEMPLATE_autosetleader07=$tmptpd[autoset];
				} else {
					//echo "2";
					$tmptpd=tmq("select * from marc_template where delable='NO' ");
					$tmptpd=tmq_fetch_array($tmptpd);
					$USINGTEMPLATE=$tmptpd[id];
					$USINGTEMPLATE_autosetleader07=$tmptpd[autoset];
				}
			}
		} else {
			$tmptpd=tmq("select * from marc_template where id='$USINGTEMPLATE' ");
			$tmptpd=tmq_fetch_array($tmptpd);
			$USINGTEMPLATE=$tmptpd[id];
			$USINGTEMPLATE_autosetleader07=$tmptpd[autoset];
		}


	$tmptp=tmq("select * from marc_template order by id");
	$newurl=$REQUEST_URI;
	$resetcolstr="";
	while ($tmptpr=tmq_fetch_array($tmptp)) {
      $newurl=str_replace("&USINGTEMPLATE=$tmptpr[id]","",$newurl);
      $resetcolstr=$resetcolstr." tmp=getobj('marctobtn$tmptpr[id]'); tmp.style.backgroundColor='#F5F5F5';tmp.style.color='#000000';";
	}

	$tmptp=tmq("select * from marc_template order by id");
	while ($tmptpr=tmq_fetch_array($tmptp)) {
		//printr($tmptpr);
		?><INPUT TYPE="button" ID="<?php echo "marctobtn$tmptpr[id]";?>" value="<?php echo getlang($tmptpr[name]);?>"
		onclick=" <?php echo $resetcolstr; ?>; this.style.backgroundColor='#0A5EB1';this.style.color='#ffffff'; <?php  
		$tmptpr[autoset]=trim(substr($tmptpr[autoset]."  ",0,1));
		if ($tmptpr[autoset]!="") {
			?>tmpautoset=getobj('local_ldild_4');  if (typeof tmpautoset !== 'undefined') { tmpautoset.value='<?php echo $tmptpr[autoset];?>'; }<?php  
		}
	$localtps=tmq("select * from bkedit where systemhide='no' ",false);
   $defvalues=tmq("select * from bkedit_defval where template='$tmptpr[fid]'",false);
   //echo "defvalues c=".tnr($defvalues);
   //tmq_dump("bkedit_defval","tag","value"," where template='$tmptpr[id]' ");
   while ($defvaluer=tfa($defvalues)) {
      //printr($defvaluer);
      ?>tmp=document.getElementsByName('data[<?php echo $defvaluer[tag];?>][]');  if (typeof tmp[0] !== 'undefined') { tmp[0].value='<?php echo addslashes($defvaluer[value]);?>'; } <?php
   }

	while ($localtpr=tmq_fetch_array($localtps)) {
		if ($localtpr[fid]==$fixedwidthfield) {
			continue;
		}
		if ($localtpr[$tmptpr[fid]]=="on") {
		//console.log('tr<?php echo $localtpr[fid];? >');
			?>tmp=getobj('tr<?php echo $localtpr[fid];?>'); if (typeof tmp !== 'undefined') { tmp.style.display='block';tmp.style.height='auto'; } <?php  
		} else {
			?>tmp=getobj('tr<?php echo $localtpr[fid];?>');  if (typeof tmp !== 'undefined') { tmp.style.display='none';tmp.style.height='auto'; } <?php  
		}
      
	}

		?>"
<?php  
if ($USINGTEMPLATE==$tmptpr[id]) {
	echo "style='background-color: #0A5EB1; color: white;'";
	$USINGTEMPLATEFID=$tmptpr[fid];
}
?>
		> <?php  
	}

//echo "[$USINGTEMPLATE]";

$defvalue=tmq_dump("bkedit_defval","tag","value"," where template='$USINGTEMPLATEFID' ");
//printr($defvalue);

	?>
	</TD>
</TR>
</TABLE>

<TABLE border=0 width=780 align=center cellspacing=0 cellpadding=2 >
<TR>
	<TD colspan=3 align=center bgcolor=f0f0f0><A HREF="javascript:void(0)" startval=hide
onclick="showhide_leadersub();"
	><B>LEADER</B> <IMG SRC="../neoimg/plus.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" ID=imgleaderobj></a></TD>

</TR>
<TR>
	<TD><span style='display: none;' id=leaderhider><TABLE width=100%>


<TR>
  <TD width="20%"><?php  local_ldi("Logical record length:เป็นส่วนที่ระบุความยาวของอักชระทั้งหมดของระเบียน ส่วนนี้โปรแกรมจะประมวลผลให้","ld_1",0,5,"",true);?></TD>
  <TD width="20%"><?php  local_ldi("Record.Status:สถานภาพของระเบียน&a - Increase in encoding level&c - Corrected or revised&d - Deleted&n - New&p - Increase in encoding level from prepublication","ld_2",5,1,"n");?></TD>
  <TD width="20%"><?php  local_ldi("Type of Record:Type of Record&a - Language material&c - Printed music&d - Manuscript music&e - Cartographic material&f - Manuscript cartographic material&g - Project medium&i - Nonmusical sound recording&k - Two-dimensional nonprojectable graphic&m - Computer file&o - Kit&p - Mixed materials&r - Three-dimensional artifact or naturall occurring object&t - Manuscript language material","ld_3",6,1,"a");?></TD>
 </TR>
<TR>
  <TD width="20%"><?php  
  local_ldi("Bibliographic level:ระดับบรรณานุกรม&a - Monograhpic component part&b - Serial component part&c - Collection&d - Subunit&m - Monograph&s - Serial","ld_4",7,1,"m","","$USINGTEMPLATE_autosetleader07","yes");?></TD>
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
	<TD colspan=5 align=center bgcolor=f0f0f0><A HREF="javascript:void(0)" startval=hide
onclick="showhide_fixfieldsub();"
	><B>Fixed Width field</B> [<?php  echo $fixedwidthfield?>]  <IMG SRC="../neoimg/plus.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" ID=imgfixwobj></a></TD>

</TR>
<TR>
	<TD>
	<span style='display: none;' id=fixwhider>
	<TABLE width=100%>




<TR>
  <TD width="40%" colspan=2><?php  local_fwi("Date Enter:Date entered on file&รูปแบบ= yymmdd&yy - เลขสองตัวสุดท้ายของปี&mm - ตัวเลข 2 ตัวของเดือน&dd - ตัวเลข 2 ตัวของวัน","fw_1",0,6,date("ymd"));?></TD>
  <TD width="20%"><?php  local_fwi("Date Type:Type of date/Publication status&ประเภทของปีพิมพ์หรือสถานภาพของสิ่งพิมพ์&b - No dates given, B.C. date involved&e - Detailed date&i - Inclusive dated of collection&K - Range of years of bulk of collection&m - Multiple dates&n - Dates unknown&p - date of distribution/release/issue and production/reording session when differen&q - Questionable date&r - Reprint/reissue date and original date&s - Single known date/probable date&t - Publication date and copyright date","fw_2",6,1,"s");?></TD>
  <TD width="20%"><?php $tmp=local_fwi("Date 1:ปีพิมพ์ 1","fw_3",7,4,"||||","yes");?> 
  <a href="javascript:void(null);"
  onclick="local_260tofw(); return false;"
  ><img src="../neoimg/icon_external_2.PNG" width="10" height="10" border="0" alt=""></a>
<script type="text/javascript">
<!--
	function local_260tofw() {
		sourcef=getobj("result_tag260");
		tmp=sourcef.getElementsByTagName('textarea')[0].value+"";
		tmp=tmp.trim();
		tmp=tmp.replace(/^\D+/g,'');
		numb=tmp.match(/\d/g);
		numb=numb.join("");
		numb=numb.toString();
		numb=numb.substring(numb.length-4,numb.length);
		//alert(numb);
		res=getobj("<?php echo $tmp;?>");
		res.value=numb;
	}
//-->
</script>
<SCRIPT LANGUAGE="JavaScript" ">
<!--
function setyearbychainid() {
   tmp=getobj("chainfrommid");
   if (tmp==undefined) return;
   selectedid=tmp.options[tmp.selectedIndex].value;
   //alert(selectedid);
   resultautosetyear="";
   <?php
		$chnlinkitems=tmq("SELECT *  FROM media_mid where pid='$chainmaster' order by inumber,jenum_1,jenum_2,jenum_3,jenum_4,jenum_5,jenum_6,jchrono_1,jchrono_2,jchrono_3,id");
		while ($chnlinkitemsr=tmq_fetch_array($chnlinkitems)) {
		    if (strlen($chnlinkitemsr[jchrono_1])==4) {
			?>if (selectedid==<?php echo floor($chnlinkitemsr[id]);?>) {
			   resultautosetyear="<?php echo $chnlinkitemsr[jchrono_1];?>";
			}<?php
			}
		}
?>
   if (resultautosetyear!="") {
      res=getobj("<?php echo $tmp;?>");
      res.value=resultautosetyear;
   }
}
setyearbychainid();
//-->
</SCRIPT>
  </TD>
  <TD width="20%"><?php  local_fwi("Date 2:ปีพิมพ์ 2","fw_4",11,4,"||||");?></TD>

	</TR>

<TR>
  <TD width="20%"><?php  local_fwi("Place:Place of publication, production, or execution&สถานที่พิมพ์ &th฿ - ต้องกรอก 3 ตัวอักษร กรณีที่ไม่ถึง ให้ใส่ ฿  เช่น  th฿","fw_5",15,3,"th ");?></TD>
  <TD width="20%"><?php  local_fwi("Illus:Illustrations&ภาพประกอบ&฿฿฿฿ - No illustration&a - Illustrations& b฿฿฿ - Maps&c฿฿฿ - Portraits&d฿฿฿ - Charts&e฿฿฿ - Plans&f฿฿฿ - Plates&g฿฿฿ - Music&h฿฿฿ - Facsimiles&j฿฿฿ - Coats of arms&j฿฿฿ - Genealogical tables&k฿฿฿ - Forms& l฿฿฿ - Samples&m฿฿฿ - Phonodisc, phomowire, etc&o฿฿฿ - Photographs&p฿฿฿ - Illumination","fw_6",18,4," ");?></TD>
  <TD width="20%"><?php  local_fwi("Audience:Target Audience&กลุ่มเป้าหมาย&฿ - Unknown or not specified&a - Preschool&b - Primary&c - Elementary and junior high&d - Secondary (senior hign)&e - Adult&f - Specialized&g - General&j - Juvenile","fw_7",22,1," ");?></TD>
  <TD width="20%"><?php  local_fwi("Form:Form of item&รูปแบบของวัสดุ&฿ - None of following&a - Microfilm&b - Microfiche&c - Microopaque&d - Large print&f - Braille&r - Regular print reproduction&s - Electronic","fw_8",23,1," ");?></TD>
  <TD width="20%"><?php  local_fwi("Content:Nature of Contents&ลักษณะเนื้อหา&฿฿฿฿ - No specifiec nature of contents&a฿฿฿ - Abstracts/summaries&b฿฿฿ - Bibliographies&c฿฿฿ - Catalogs&d฿฿฿ - Dictionaries&e฿฿฿ - Encyclopedias&f฿฿฿ - Handbooks&g฿฿฿ - Legal articles&i฿฿฿ - Indexes&j฿฿฿ - Patent document&k฿฿฿ - Discographies&l฿฿฿ - Legislation&m฿฿฿ - Theses&n฿฿฿ - Surveys of literature in a subject area&o฿฿฿ - Reviews&p฿฿฿ - Programmed texts&q฿฿฿ - Filmographies&r฿฿฿ - Directories&s฿฿฿ - Statistics&t฿฿฿ - Technical reports&v฿฿฿ - Legal cases and case notes&w฿฿฿ - Law reports and digests&z฿฿฿ - Treaties","fw_9",24,4," ");?></TD>
  </TR>
<TR>
  <TD width="20%"><?php  local_fwi("Gov.:Government publication&สิ่งพิมพ์รัฐบาล&฿ - Not a government publication&a - Autonomous or semi-autonomous component&c - Multilocal&f - Federal/National&i - International intergovernment&l - Local&m - Multistate&o - Government publication - level undetermined&s - State, provincial, territorial, dependent&u - Unknown if item is govenment publication&z - Other","fw_10",28,1," ");?></TD>
  <TD width="20%"><?php  local_fwi("Conf.:Conference publication&เอกสารการประชุม&0 - not a confetence publication&1 - Conference publication","fw_11",29,1,"0");?></TD>
  <TD width="20%"><?php  local_fwi("Fest.:Festschrift&หนังสือที่ระลึก&0 - Not festschrift&1 - Festschrift","fw_12",30,1,"0");?></TD>
  <TD width="20%"><?php  local_fwi("Ind.:Index&ดรรชนี&0 - No index&1 - Index present","fw_13",31,1,"0");?></TD>
  <TD width="20%"><?php  local_fwi("Undefined","fw_14",32,1," ");?></TD>
  </TR>
<TR>
  <TD width="20%"><?php  local_fwi("Literary form:รูปแบบวรรณกรรม&&0 - Not fiction (not further specified)&1 - Fiction (not further specified)&c - Comic strips&d - Dramas&e - Essays&f - Novels&h - Humor, satires, etc&i - Letters&j - Short stories&m - Mixed forms&p - Poetry&s - Speaches&u - Unknown","fw_15",33,1,"0");?></TD>
  <TD width="20%"><?php  local_fwi("Biog:Biography&ชีวประวัติ&฿ - No biographical material&a - Autobiography&b - Individual biography&c - Collective biography&d - Contains biographical information","fw_16",34,1," ");?></TD>
  <TD width="20%"><?php  local_fwi("Lang:Language&ภาษา ใช้ตาม MARC Code List for Language&฿฿฿ - Blanks&tha - ภาษาไทย&eng - English&mul - Multiple languages&sgn - Sign anguages&und - ใช้สำหรับภาษาที่ไม่สามารถตัดสินใจได้ว่าเป็นภาษาใด","fw_17",35,3,"tha","yes");?></TD>
  <TD width="20%"><?php  local_fwi("mod.:Modified recrd&&฿ - Not modified&s - Shorten& d Dashed-on information omitted&x - Missing characters&r - Completely romanized/printed cards in scrip&o - Completely romanized/ printed catds romanized","fw_18",38,1," ");?></TD>
  <TD width="20%"><?php  local_fwi("source:Cataloging source&แหล่งที่ทำการวิเคราะห์&฿ - National Bibliographic agency&c - Cooperative cataloging program&d - Other&u - Unknown","fw_19",39,1,"d");?></TD>
  </TR>


	
	</TABLE>
	</span>
	</TD>
</TR>


</TABLE>

<table width =970 align = center border=0 cellpadding = 1 cellspacing =0>
<?php  

$sql82="select * from bkedit where systemhide='no' order by ordr";
$result=tmq($sql82);

$autoaddtitle=getval("MARC","add-autotitle-to");
$autoaddisbn=getval("MARC","add-isbn-to");
$autoaddauthorname=getval("MARC","add-authname-to");

if ($acqid!="") {
	$acq=tmq("select * from acq_tocatalog where id=$acqid ");
	if (tmq_num_rows($acq)==0) {
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("ไม่พบรายการหนังสือจากฝ่ายจัดหา v.1 หมายเลข <?php echo $acqid;?>");
		//-->
		</SCRIPT><?php  
	} else {
		$hasacq="yes";
		$acq=tmq_fetch_array($acq);
		$acqmarc=getval("acq","marc_map");
		$acqmarc=explodenewline($acqmarc);
		$marcmap=Array();
		foreach ($acqmarc as $acqkey => $acqvalue) {
			$tmpacq1=explode("=",$acqvalue);
			$tmpacq1[1]=str_replace("%d_titl%",$acq[d_titl],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%d_auth%",$acq[d_auth],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%d_publ%",$acq[d_publ],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%d_yea%",$acq[d_yea],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%d_edition%",$acq[d_edition],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%d_isbn%",$acq[d_isbn],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%d_imprint%",$acq[d_imprint],$tmpacq1[1]);
			$marcmap[$tmpacq1[0]]=$tmpacq1[1];
		//print_r($marcmap);
		}

	}
}//end if ($acqid!="") 

$loadacqxls=floor($loadacqxls);
if ($loadacqxls!=0) {
	$acq=tmq("select * from acqn_sub where id=$loadacqxls ");
	if (tmq_num_rows($acq)==0) {
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("ไม่พบรายการหนังสือจากฝ่ายจัดหา หมายเลข <?php echo loadacqxls;?>");
		//-->
		</SCRIPT><?php  
	} else {
		$hasacq="yes";
		$acq=tmq_fetch_array($acq);
		$acqmarc=getval("acq","marc_mapv2");
		$acqmarc=explodenewline($acqmarc);
		$budget=tmq("select * from acqn_budget where code='$acq[budget]' ");
		$budget=tfa($budget);
		$budget=$budget[name];
		$marcmap=Array();
		foreach ($acqmarc as $acqkey => $acqvalue) {
			$tmpacq1=explode("=",$acqvalue);
			$tmpacq1[1]=str_replace("%d_titl%",$acq[titl],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%d_auth%",$acq[auth],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%d_isbn%",$acq[isn],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%d_yea%",$acq[yea],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%d_publ%",$acq[s_store],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%s_name%",$acq[s_name],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%s_email%",$acq[s_email],$tmpacq1[1]);
			$tmpacq1[1]=str_replace("%budget%",$budget,$tmpacq1[1]);
			$marcmap[$tmpacq1[0]]=$tmpacq1[1];
		//print_r($marcmap);
		}

	}
}//end if ($acqid!="") 



                                        while ($row=tmq_fetch_array($result)) {
if ($row[isrepeat]!="R") {
		?>
<script type="text/javascript">
<!--
	taglistiscanrepeat.push("<?php echo $row[fid];?>");
//-->
</script><?php  
}
											//printr($row);
											$defaultindi1=substr($row[defindi1],0,1);
											$defaultindi2=substr($row[defindi2],0,1);
											if ($defaultindi1=="b") { $defaultindi1="_";}
											if ($defaultindi2=="b") { $defaultindi2="_";}
												if ($row[fid]==$fixedwidthfield) {
													continue;
												}

//โหลดข้อมูลหนังสือใหม่
if ($hasacq=="yes") {
	if ($marcmap[$row[fid]]!="") {
		$x[$row[fid]]="  ".$marcmap[$row[fid]];
	}
}


//load default value
if ($IDEDIT=="" && $usethemarc!="yes" && $hasacq!="yes" && $yazid=="") {
	$x[$row[fid]]=$defvalue[$row[fid]];
	if ($defvalue[$row[fid]]!="") {
		$defaultindi1=substr($defvalue[$row[fid]],0,1);
		$defaultindi2=substr($defvalue[$row[fid]],1,1);
	}
}
	if ($row[fid]==$autoaddtitle && trim($loadtitle)!="") {
		$x[$row[fid]]="  ^a$loadtitle";
	}
	if ($row[fid]==$autoaddisbn && trim($loadisbn)!="") {
		$x[$row[fid]]="  ^a$loadisbn";
	}
	if ($row[fid]==$autoaddauthorname && trim($loadauth)!="") {
		$x[$row[fid]]="  ^a$loadauth";
	}

?>
<tr bgcolor = "#f3f3f3" id="tr<?php  echo $row[fid]?>" valign=top
<?php  

if ($row[$USINGTEMPLATEFID]=='on' || trim($x[$row[fid]])!="")	 {
	echo " style='display: block;' ";
} else {
	echo " style='display: none;' ";
}
?>>
<?php  
$infos="<B class=smaller>".addslashes(getlang("$row[name]"))."</B><BR>Detail:".addslashes(getlang("$row[descr]"));
$infos=addslashes(str_replace($newline,"<BR>",$infos));
$infos=addslashes(str_replace(chr(13),"<BR>",$infos));
$infos=addslashes(str_replace(chr(10),"<BR>",$infos));
$infos=addslashes(str_replace("<BR><BR>","<BR>",$infos));
$infos=addslashes(str_replace("<BR><BR>","<BR>",$infos));
$infos=explodenewline($infos);
//printr($infos);
$infos=implode($infos," ");
?>
	<td class=tagtr width = "100"  align=center >
<A href="javascript:void(null);" onMouseover="fixedtooltip('<?php echo addslashes(str_replace($newline,"<BR>",$infos));?>', this, event, '850px')" 
style="color: black ; font-weight: bold;" 
onMouseout="delayhidetip()"
><?php  
	echo str_replace("tag","",$row[fid]);
		?>
</A><?php local_bookjshelp($row[fid],$row); ?></td>	
<td class=tagtr width = "830">
		
		<TABLE border=0 width=830 cellpadding=0 cellspacing=0><!-- ตารางสำหรับจัดบรรทัดที่มี  (canrepeat=R) -->
		<TR valign=top><TD style="background-color: f9f9f9"><span ID="source_<?php echo $row[fid]?>" style="display:none"><?php  
				if ($row[ishasindi]=="NO") {
						echo "<textarea TABINDEX=\"[TAGPUREID]\" NAME=\"data[[CONTROLTAGNAME]][]\"  rows=1 style='width: 685px;'
						ID=\"data[RANDOMHERE]\" 
						onblur=\"setlastfocus('data[RANDOMHERE]','$row[fid]');\" 
						onfocus=\"setlastfocus('data[RANDOMHERE]','$row[fid]');\" class=localbookinput  
						onkeydown=\"FitToContent(this,'none'); return localbookinputkeydown(event,'";
						//echo "<INPUT TYPE=text NAME=\"data[[CONTROLTAGNAME]][]\" AUTOCOMPLETE=off ID=\"data[RANDOMHERE]\" onblur=\"setlastfocus('data[RANDOMHERE]','$row[fid]');\" onfocus=\"setlastfocus('data[RANDOMHERE]','$row[fid]');\" value=\"[INPUTEDDATA]\" size=87 class=localbookinput  onkeydown=\"return localbookinputkeydown('";
					if ($row[isrepeat]=="R") {	
						echo $row[fid]; 
					}
					echo "','$defaultindi1','$defaultindi2','";
					echo substr($defvalue[$row[fid]],2);
					echo "')\">[INPUTEDDATA]</textarea> ";
				} else {
				   //echo "<div style='display: inline-block;'>";
					local_indiform("dataindi1[[CONTROLTAGNAME]][]",$row[defindi1],"[CHOOSENINDI1]");
					local_indiform("dataindi2[[CONTROLTAGNAME]][]",$row[defindi2],"[CHOOSENINDI2]");
					//print_r($defindi1);
					//echo "</div>";
					echo "
					<div 
					id='data[RANDOMHERE]_sftop'
					style='position:relative; display: inline-block; height: auto; width: auto; min-height: 22px; padding-top: 2px; min-width:600px; border: 0px solid red;'>
					<div style='position:absolute;display: inline-block; height: auto; top: 0px;
					margin-bottom: 0px;
margin-left: 0px;
margin-right: 0px;
margin-top: 0px;
padding-bottom: 0px;
padding-left: 2px;
padding-right: 0px;
padding-top: 2px;
text-transform: none;
white-space: pre-wrap;
width: 600px;
word-spacing: 0px;
word-wrap: break-word;
writing-mode: lr-tb;
color: white;
' id='data[RANDOMHERE]_sf'></div>
					<div style='position:absolute;display: inline-block; height: auto; top: 0px;'>
					<textarea TABINDEX=\"[TAGPUREID]\" name='data[[CONTROLTAGNAME]][]' rows=1 
					 style='width: 600px; background-image:none; background-color: transparent;'
					 ID='data[RANDOMHERE]'
					 onblur=\"setlastfocus('data[RANDOMHERE]','$row[fid]');\"
					 onfocus=\"setlastfocus('data[RANDOMHERE]','$row[fid]'); localhilightsubfields('data[RANDOMHERE]','[TAGPUREID]'); \"
					 value=\"[INPUTEDDATA]\" ondblclick=\"doubleclicktag(this)\" 
					 class=localbookinput 
					 onkeydown=\"FitToContent(this,'dataindi2[[CONTROLTAGNAME]][]');  return localbookinputkeydown(event,'";
					if ($row[isrepeat]=="R") {	
						echo $row[fid]; 
					}
					echo "','$defaultindi1','$defaultindi2','";
					echo substr($defvalue[$row[fid]],2);
					echo "')\"
					onkeyup=\"localhilightsubfields('data[RANDOMHERE]','[TAGPUREID]')\"
					>[INPUTEDDATA]</textarea></div></div>
					";
				}

	$helpsuggeststr="";

		if ($adb[$row[fid]] == "yes") {
			$helpsuggeststr.= "<B onclick=\"fixedtooltipforsuggest('../_misc/auth.php?mid=$IDEDIT&tagid=$row[fid]&parentjsid=data[RANDOMHERE]', this, event, '600px','<B style=color:#FF3300>Authority Control Check</B>')\" ><img src=\"a.gif\" border=0 width=16 height=16></B>";
		}
	if ("$row[fid]"=="$helpsuggeststr_auth") {
		$helpsuggeststr.="<B onclick=\"fixedtooltipforsuggest('../_misc/thaicutter.php?mid=$IDEDIT&tagid=$row[fid]&parentjsid=data[RANDOMHERE]&recparentval='+(getobj('data[RANDOMHERE]').value), this, event, '550px','". getlang("เลขผู้แต่งภาษาไทย::l::Thai Author Number")."')\" ><img src=\"$dcrURL"."neoimg/authname-th.png\" border=0 width=16 height=16></B>";
		$helpsuggeststr.="<B onclick=\"fixedtooltipforsuggest('../_misc/sanborncutter.php?mid=$IDEDIT&tagid=$row[fid]&parentjsid=data[RANDOMHERE]&recparentval='+(getobj('data[RANDOMHERE]').value), this, event, '550px','". getlang("เลขผู้แต่งภาษาอังกฤษ::l::English Author Number")."')\" ><img src=\"$dcrURL"."neoimg/authname-en.png\" border=0 width=16 height=16></B>";
	}
	if ("$row[fid]"=="$helpsuggeststr_localcallc") {
		$helpsuggeststr.="<B onclick=\"fixedtooltipforsuggest('../_misc/callngenner.php?mid=$IDEDIT&tagid=$row[fid]&parentjsid=data[RANDOMHERE]&recparentval='+(getobj('data[RANDOMHERE]').value), this, event, '550px','". getlang("Running เลขเรียก::l::Running Call Number")."')\" ><img src=\"$dcrURL"."neoimg/localcalln.png\" border=0 width=16 height=16></B>";
	}
	if ("$row[fid]"=="$helpsuggeststr_dc") {
		$helpsuggeststr.="<B onclick=\"fixedtooltipforsuggest('../_misc/dclist.php?mid=$IDEDIT&tagid=$row[fid]&parentjsid=data[RANDOMHERE]', this, event, '550px','DC - Call number')\" ><img src=\"$dcrURL"."neoimg/calln-dc.png\" border=0 width=16 height=16></B>";
	}
	if ("$row[fid]"=="$autoaddtitle") {
		$helpsuggeststr.="<B onclick=\"fillcallntitledc('data[RANDOMHERE]');\" ><img src=\"$dcrURL"."neoimg/uptod.png\" border=0 width=16 height=16></B>";
		$helpsuggeststr.="<B onclick=\"fillcallntitlelc('data[RANDOMHERE]');\" ><img src=\"$dcrURL"."neoimg/uptol.png\" border=0 width=16 height=16></B>";
		$helpsuggeststr.="<B onclick=\"fillcallntitlenlm('data[RANDOMHERE]');\" ><img src=\"$dcrURL"."neoimg/upton.png\" border=0 width=16 height=16></B>";
		$helpsuggeststr.="<B onclick=\"fillcallntitlelocalc('data[RANDOMHERE]');\" ><img src=\"$dcrURL"."neoimg/upto9.png\" border=0 width=16 height=16></B>";
	}
	if ("$row[fid]"=="$helpsuggeststr_lc") {
		$helpsuggeststr.="<B onclick=\"fixedtooltipforsuggest('../_misc/lclist.php?mid=$IDEDIT&tagid=$row[fid]&parentjsid=data[RANDOMHERE]', this, event, '550px','LC - Call number')\" ><img src=\"$dcrURL"."neoimg/calln-lc.png\" border=0 width=16 height=16></B>";
	}
	if ("$row[fid]"=="$helpsuggeststr_nlm") {
		$helpsuggeststr.="<B onclick=\"fixedtooltipforsuggest('../_misc/nlmlist.php?mid=$IDEDIT&tagid=$row[fid]&parentjsid=data[RANDOMHERE]', this, event, '550px','LC - Call number')\" ><img src=\"$dcrURL"."neoimg/calln-nlm.png\" border=0 width=16 height=16></B>";
	}
	if ($row[subj] == "on") {
		$helpsuggeststr.="<B onclick=\"fixedtooltipforsuggest('../_misc/subjextract.php?mid=$IDEDIT&tagid=$row[fid]&parentjsid=data[RANDOMHERE]', this, event, '600px','Search Subject')\" ><img src=\"calln-subj.png\" border=0 width=16 height=16></B>";
	}

	echo $helpsuggeststr;

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
		?><img src="<?php echo $dcrURL?>neoimg/spacer.gif" border=0 width=24 height=1 hspace=0 vspace=0><?php  
	}
	if (trim($row[quicktext])!="") {
		/*?><pre><?php  echo $row[quicktext]?></pre><?php  */
		?>
		<a href="javascript:void(null);" onclick="tmp=getobj('<?php  echo $row[fid]?>qtTT');tmp.style.display='inline-block';"><img src="<?php echo $dcrURL?>neoimg/quicktext.png" border=0 width=24 height=24 hspace=0 vspace=0></a>
		<div class="tooltipxx" ID="<?php  echo $row[fid]?>qtTT">
    <p style="padding-top: 0px; text-align: left;"><?php  
			$al=explodenewline($row[quicktext]);
			//printr($al);
			@reset($al);
			while (list($qtk,$qtv)=each($al)) {
				?><a href="javascript:void(null);" onclick="<?php  
				if ($row[isrepeat]!="R") {
						?>removemarcbytag('<?php  echo $row[fid]?>'); duplicatemarc('<?php echo $row[fid] ?>','<?php  echo $defindi1;?>','<?php  echo $defindi2;?>','<?php  echo $qtv?>','no');<?php  
				 } else {
				 ?> duplicatemarc('<?php  echo $row[fid]?>','<?php  echo $defindi1;?>','<?php  echo $defindi2;?>','<?php  echo $qtv?>','yes');<?php  
				 }
				?>;tmp=getobj('<?php  echo $row[fid]?>qtTT'); tmp.style.display='none';"><b><?php echo $qtv;?></b></a><br><?php  
			}
			 ?>
			 <a href="javascript:void(null);" onclick=" tmp=getobj('<?php  echo $row[fid]?>qtTT'); tmp.style.display='none';">Close</a></p>
    <div class="tooltipxxtailShadow"></div>
    <div class="tooltipxxtail1"></div>
    <div class="tooltipxxtail2"></div>
</div>
<?php  
	}
?>
		 </TD>
		<TD valign=top style="padding-top:12; padding-left: 3; padding-right:3; border-right-width: 1;" class=tagtr><nobr>
			<a href="javascript:void(null)" onclick="getobj('tr<?php echo $row[fid]; ?>').style.display='none';getobj('tr<?php echo $row[fid]; ?>').style.height=0;getobj('link<?php echo $row[fid]; ?>').style.display='inline'; " ><IMG SRC="minimize.png" WIDTH="12" HEIGHT="12" BORDER="1" TITLE="<?php echo getlang("ซ่อนแท็ก::l::Hide"); ?>" style="border-color:#575757"></a></nobr></TD>

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
				if ($sourcecount==1) {
					if ("$row[fid]"=="$helpsuggeststr_localcallc") {
						?>
							helpsuggeststr_localc_tag=firstid+"";
						<?php  
					}
					if ("$row[fid]"=="$helpsuggeststr_lc") {
						?>
							helpsuggeststr_lc_tag=firstid+"";
						<?php  
					}
					if ("$row[fid]"=="$helpsuggeststr_nlm") {
						?>
							helpsuggeststr_nlm_tag=firstid+"";
						<?php  
					}
					if ("$row[fid]"=="$helpsuggeststr_dc") {
						?>
							helpsuggeststr_dc_tag=firstid+"";
						<?php  
					}
				}
		}
	}
	//if ($sourcecount==0 && $row[isrepeat]!="R") {
	if ($sourcecount==0 ) {
		if ($row[isrepeat]!="R") {
			?>firstid=duplicatemarc("<?php echo $row[fid]; ?>","<?php echo $defaultindi1;?>","<?php echo $defaultindi2;?>","","no");<?php  
		} else {
			?>firstid=duplicatemarc("<?php echo $row[fid]; ?>","<?php echo $defaultindi1;?>","<?php echo $defaultindi2;?>","","no");<?php  
		}
		//echo "($row[fid]==$helpsuggeststr_lc)xxxxxxxxxxx";
		if ("$row[fid]"=="$helpsuggeststr_localcallc") {
			?>
				helpsuggeststr_localc_tag=firstid+"";
			<?php  
		}
		if ("$row[fid]"=="$helpsuggeststr_lc") {
			?>
				helpsuggeststr_lc_tag=firstid+"";
			<?php  
		}
		if ("$row[fid]"=="$helpsuggeststr_nlm") {
			?>
				helpsuggeststr_nlm_tag=firstid+"";
			<?php  
		}
		if ("$row[fid]"=="$helpsuggeststr_dc") {
			?>
				helpsuggeststr_dc_tag=firstid+"";
			<?php  
		}
	}  else {
		//echo "alert(\"$row[fid] $sourcecount\");";
	}
	?>	//-->
	</SCRIPT>
	<?php  
                                            } // end while bkedit
                                    ?>
<?php  
if ($IDEDIT!="") {
?>
<TR bgcolor=white>
	<TD colspan=4>
	<?php echo getlang("ตัวเลือกการบันทึก::l::Save options"); ?> : 
	<LABEL><INPUT TYPE="radio" NAME="IDEDIT" value="<?php echo $IDEDIT?>" checked class=checkbox> <?php echo getlang("บันทึกรายการ::l::Save"); ?></LABEL>
	<LABEL><INPUT TYPE="radio" NAME="IDEDIT" value="" class=checkbox> <?php echo getlang("บันทึกเป็นรายการใหม่::l::Save as duplicate:"); ?></LABEL>
	<input type=hidden name="ORIGIDEDIT" value="<?php echo $IDEDIT?>">
	</TD>
</TR>
<?php  
}
?>
                                    <tr bgcolor=white>
                                        <td colspan=5 align=center>
										<?php $lastbringmeto=sessionval_get("addbook-bringmeto");?>
										<?php echo getlang("เสร็จแล้วไปที่::l::After saved go to"); ?> : 
										<?php if ($forcebringmeto=="") {?>
											<LABEL><INPUT TYPE="radio" NAME="bringmeto" style="border-width:0" value="" <?php if ($lastbringmeto=="" && $chainid=='') { echo "checked";}?>> 
											<?php echo getlang("รายการวัสดุฯ::l::Material database"); ?></LABEL>  - 
											<?php if ($chn[name]!="") {?>
											<LABEL><INPUT TYPE="radio" NAME="bringmeto" style="border-width:0" value="backtochain" <?php if (($lastbringmeto=="" || $lastbringmeto=="backtochain") && $chainid!='') { echo "checked";}?>> 
											<?php echo getlang("กลับไป$chn[name]::l::Back to $chn[name]"); ?></LABEL>  - 
											<?php  }?>
											<LABEL><INPUT TYPE="radio" NAME="bringmeto" style="border-width:0" value="addnewrecord" <?php if ($lastbringmeto=="addnewrecord") { echo "checked";}?>>
											<?php echo getlang("เพิ่มรายการใหม่::l::Add another record"); ?></LABEL>  - 
		
											<LABEL><INPUT TYPE="radio" NAME="bringmeto" value="addnewitem"style="border-width:0"  <?php if ($lastbringmeto=="addnewitem") { echo "checked";}?>>
											<?php echo getlang("เพิ่มไอเท็มให้รายการนี้::l::Add items for this record"); ?></LABEL>
										<?php } else {
												if ($forcebringmeto=="serial") {
													echo getlang("ระบบวารสาร::l::Serial Module");
												}
											} ?>
										
										<BR>
                                            <input type = "submit" value = "Submit" onmousedown="window.normalleavingpage=true;">
											<input type = "reset" value = "Reset"><font face = 'MS Sans Serif' size = 2>
											
                                            <div align = "center">
                                                <b><B><a href = "DBbook.php?sid=<?php echo $sid ?>&typeid=<?php echo $typeid ?>&faculty=<?php 
echo $faculty ?>&startrow=<?php 
echo $startrow ?>&linkfrom=<?php 
echo $IDEDIT ?>" class=a_btn>Back</a></B></b> 

</div>
                                        </td></tr>
										<tr bgcolor=white><td colspan=5 align=center><TABLE width=600 >
	<TR>
	<TD class="table_head smaller"><?php echo getlang("เผยแพร่ Bib นี้::l::Publish this bib");?></TD>
	<TD class=table_td>
<?php  
//printr($_POST);
$ise=library_gotpermission("bibpublish");
if ($ise==true) {
	$x[ispublish]=strtolower($x[ispublish]);
	if ($x[ispublish]=="") {
		$x[ispublish]="yes";
	}
?>
	<label style="color:darkgreen" class=smaller2><INPUT TYPE="radio" NAME="ispublish" value="yes"
	<?php if ($x[ispublish]=="yes") { echo " checked ";}	?>
	><?php echo getlang("เผยแพร่::l::Publish");?></label>
	<label style="color:darkred"  class=smaller2><INPUT TYPE="radio" NAME="ispublish" value="no" 	
	<?php if ($x[ispublish]!="yes") { echo " checked ";}	?>
><?php echo getlang("ไม่เผยแพร่::l::Not publish");?></label>
<?php  
} else {
	if ($x[ispublish]=="") {
		$x[ispublish]="no";
	}
	?><input type="hidden" name="ispublish" value="<?php echo $x[ispublish]?>"><?php echo getlang("ไม่เผยแพร่::l::Not publish");?><?php  
}
	?>
	</TD>
</TR>
</TABLE></td></tr>
                                </form>
                    </table>


					<table width = <?php echo $_TBWIDTH?> align = center border = 0 cellpadding = 3 cellspacing = 0 >
<TR>
	<TD>
	<FIELDSET>
<LEGEND style="color: #484F84"><B> <IMG SRC="maximize.png" WIDTH="12" HEIGHT="12" BORDER="1" style="border-color:#777777"> <?php echo getlang("แสดงแท็กเพิ่มเติม::l::More Tags"); ?> </B></LEGEND>
	 <?php  
$sql82="select * from bkedit where  fid<>'$fixedwidthfield' and systemhide='no' order by ordr";
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
		echo "onclick=\"tmp=getobj('tr$row[fid]'); tmp.style.display='block';tmp.style.height='auto';this.style.display='none'\" title=\"$row[name]\">".str_replace("tag","",$row[fid])." </A>";
}
	?></FIELDSET>
		<FIELDSET>
<LEGEND style="color: #484F84"><B><?php echo getlang("เครื่องมือเสริม::l::Misc. tools"); ?>:</B></LEGEND>
	<A HREF="javascript:void(0)" onclick="window.open('<?php echo $dcrURL?>/_misc/subjextract.php','subjextract','width=780,height=450,scrollbars =yes');" class=a_btn><?php echo getlang("ค้นหาหัวเรื่อง::l::Search Subjects");?></A> 
	<!-- <A HREF="../_misc/kb.lib.exe" class=a_btn>ตัวช่วยกรอก Subfield</A> -->
	<A HREF="javascript:void(0)" onclick="window.open('<?php echo $dcrURL?>/_misc/dclist.php','dclist','width=780,height=450,scrollbars =yes');" class=a_btn><?php echo getlang("ค้นหา DC::l::Search DC");?></A>
	<A HREF="javascript:void(0)" onclick="window.open('<?php echo $dcrURL?>/_misc/sanborncutter.php','authnosanborn','width=780,height=450,scrollbars =yes');" class=a_btn><?php echo getlang("ตารางให้ชื่อผู้แต่งภาษาอังกฤษ::l::Sanborn Cutter Table");?></A>
	<?php if (floor($IDEDIT)!=0) { //echo "[$IDEDIT]"; ?>
	  <A HREF="setchainitem.php?IDEDIT=<?php  echo $IDEDIT;s?>"  class=a_btn><?php echo getlang("โยงรายการนี้เป็นดรรชนีวารสาร::l::Relocate this bib as journal index");?></A>
	<?php  }?>
</FIELDSET></TD>
</TR>
</TABLE>
                    <br>
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
<SCRIPT LANGUAGE="JavaScript">
<!--
function addtodcnum(str) {
	tmp=getobj("data"+helpsuggeststr_dc_tag);
	tmp.value=tmp.value+str;
	showhidesuggestme_justhide();
}
function addtolocalcnum(str) {
	tmp=getobj("data"+helpsuggeststr_localc_tag);
	tmp.value=tmp.value+str;
	showhidesuggestme_justhide();
}
function addtonlmnum(str) {
	tmp=getobj("data"+helpsuggeststr_nlm_tag);
	tmp.value=tmp.value+str;
	showhidesuggestme_justhide();
}
function addtolcnum(str) {
	tmp=getobj("data"+helpsuggeststr_lc_tag);
	tmp.value=tmp.value+str;
	showhidesuggestme_justhide();
}

function fillcallntitledc(objid) {
	tmp=getobj(objid);
	tmps=tmp.value+'';
	tmps=tmps.replace("^a", "");
	tmps=tmps.replace("^b", "");
	tmps=tmps.replace("เ", "");
	tmps=tmps.replace("แ", "");
	tmps=tmps.trim();
	console.log(tmps);
	if (tmps.substring(0,1)=='^') {
		useval=tmps.substring(2,3);
	} else {
		useval=tmps.substring(0,1);
	};

	tmp=getobj("data"+helpsuggeststr_dc_tag);
	tmp.value=tmp.value+useval;
}
function fillcallntitlelocalc(objid) {
	tmp=getobj(objid);
	tmps=tmp.value+'';
	tmps=tmps.replace("^a", "");
	tmps=tmps.replace("^b", "");
	tmps=tmps.replace("เ", "");
	tmps=tmps.replace("แ", "");
	if (tmps.substring(0,1)=='^') {
		useval=tmps.substring(2,3);
	} else {
		useval=tmps.substring(0,1);
	};

	tmp=getobj("data"+helpsuggeststr_localc_tag);
	tmp.value=tmp.value+useval;
}
function fillcallntitlenlm(objid) {
	tmp=getobj(objid);
	tmps=tmp.value+'';
	tmps=tmps.replace("^a", "");
	tmps=tmps.replace("^b", "");
	tmps=tmps.replace("เ", "");
	tmps=tmps.replace("แ", "");
	if (tmps.substring(0,1)=='^') {
		useval=tmps.substring(2,3);
	} else {
		useval=tmps.substring(0,1);
	};

	tmp=getobj("data"+helpsuggeststr_nlm_tag);
	tmp.value=tmp.value+useval;
}
function fillcallntitlelc(objid) {
	tmp=getobj(objid);
	tmps=tmp.value+'';
		tmps=tmps.replace("^a", "");
	tmps=tmps.replace("^b", "");
	tmps=tmps.replace("เ", "");
	tmps=tmps.replace("แ", "");
	if (tmps.substring(0,1)=='^') {
		useval=tmps.substring(2,3);
	} else {
		useval=tmps.substring(0,1);
	};

	tmp=getobj("data"+helpsuggeststr_lc_tag);
	tmp.value=tmp.value+useval;
}
//-->
</SCRIPT>
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
if (ie||ns6) {
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
	if (ie||ns6)
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
		var windowedge=ie && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
		localdropmenuobj.contentmeasure=localdropmenuobj.offsetWidth
		if (windowedge-localdropmenuobj.x < localdropmenuobj.contentmeasure)
			edgeoffset=localdropmenuobj.contentmeasure-obj.offsetWidth
	}
	else{
		var windowedge=ie && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
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

	if (ie||ns6) {
		showhide(dropmenuobj.style, e, "visible", "hidden", tipwidth,dropmenuobj)
		dropmenuobj.x=getposOffset(obj, "left")
		//dropmenuobj.y=getposOffset(obj, "top")
		dropmenuobj.y=5
		dropmenuobj.style.left=(dropmenuobj.x+50)-clearbrowseredge(obj, "rightedge",dropmenuobj)+"px"
		tmp=getobj('fixedtipdiv');
		dropmenuobj.style.top=dropmenuobj.y+clearbrowseredge(obj, "bottomedge",dropmenuobj)+(obj.offsetHeight-tmp.clientHeight)+"px"//-tmp.clientHeight
		
		//local_getPosition(obj)-tmp.clientHeight-5
		dropmenuobj.style.top=local_getPosition(obj)-tmp.clientHeight-5//+tmp.clientHeight-(local_getPosition(obj)+50)+"px"//-tmp.clientHeight
	}
}

function hidetip(e){
if (typeof dropmenuobj!="undefined"){
	if (ie||ns6)
		dropmenuobj.style.visibility="hidden"
	}
}

function delayhidetip(){
	if (ie||ns6)
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

	if (ie||ns6) {
		showhide(dropmenuobjforsuggest.style, e, "visible", "hidden", tipwidth,dropmenuobjforsuggest)
		dropmenuobjforsuggest.x=getposOffset(obj, "left")
		dropmenuobjforsuggest.y=getposOffset(obj, "top")
		dropmenuobjforsuggest.style.left=dropmenuobjforsuggest.x-clearbrowseredge(obj, "rightedge",dropmenuobjforsuggest)+"px"
		dropmenuobjforsuggest.style.top=dropmenuobjforsuggest.y-clearbrowseredge(obj, "bottomedge",dropmenuobjforsuggest)+obj.offsetHeight+"px"
	}
}

</script>

<!--suggest me css & js end-->

<script type="text/javascript">
<!--
	function mergemarc() {
		mmv=getobj("mergemarcta");
		mmv=mmv.value;
		//alert(mmv);
		var mmva = mmv.split("\n");
		var resa=Array();
		var ress="";
		var lasttag="000";
		for (var i = 0; i < mmva.length; i++) {
			key=mmva[i].substring(0,3);
			if (key!="   ") {
				lasttag=key;
				ress=ress+"\n"+key+"::"+mmva[i];
			} else {
				ress=ress+""+mytrim(mmva[i]);
			}
			resa[key]=mmva[i];
			//alert(mmva[i]);
			//Do something
		}
		for (var i = 0; i < 100; i++) {
			ress=ress.replace("$","^");
			ress=ress.replace("|","^");
		}
		//alert(ress);
		mmv=getobj("mergemarcta");
		mmv.value=ress;
		var mmva2 = ress.split("\n");
		for (var i = 0; i < mmva2.length; i++) {
			tagid=mmva2[i].substring(0,3);
			tagid=mytrim(tagid);
			indi1=mmva2[i].substring(9,10);
			indi2=mmva2[i].substring(10,11);
			marcval=mmva2[i].substring(12,1000);
			errored=false;
			if (tagid.length==3) {
				try {
					newhtml=getobj("source_"+tagid);
					newhtml=getobj("result_"+tagid);
				  }
				catch(err)
				  {
					errored=true;
					alert(" error:" + wh);
				  //Handle errors here
				  }
				if (errored==false) 	{
					if(taglistiscanrepeat.indexOf("tag"+tagid) != -1) 	{  
					   // element found - can repeat
						removemarcbytag("tag"+tagid);
						duplicatemarc("tag"+tagid,indi1,indi2,marcval);
						mmv.value=mmv.value+"\n replacing "+tagid+"/"+indi1+"/"+indi2+"/"+marcval+"/";
						//alert('trtag'+tagid);
					} else {
						duplicatemarc("tag"+tagid,indi1,indi2,marcval);
						mmv.value=mmv.value+"\n adding "+tagid+"/"+indi1+"/"+indi2+"/"+marcval+"/";
					}
				}
			}
		}
		mmv.value="";
	}
	
	//confirm leaving page
	window.normalleavingpage=false;
	window.onbeforeunload = function () {
	  if (window.normalleavingpage==true) {
	     //ok
	  } else {
	     return '<?php echo getlang("ยังไม่ได้บันทึกข้อมูล ยืนยันการไปเพจอื่น?::l::You have unsaved changes!");?>';
	  }
   };
//-->
</script>
<div ID="mergemarcdiv" style="background-color: white; position: absolute; top: 0px; left:0px; width: 100%; height: 400px;display:none; "><center><?php  
	pagesection(getlang("วางมาร์ค::l::Paste MARC"));
?>
<form method="post" action="">
<?php echo getlang("วางมาร์คที่นี่::l::Paste MARC here");?><br>
	<textarea name="mergemarcta" ID="mergemarcta" style="width: 500px; height: 200px;" rows="" cols=""></textarea>
</form><br><br>
<a href="javascript:void(null);" class="a_btn bigger" style="" onclick="mergemarc(); tmp=getobj('mergemarcdiv'); tmp.style.display='none';;"><?php echo getlang("ตกลง::l::OK");?></a>
<a href="javascript:void(null);" class="a_btn" onclick="tmp=getobj('mergemarcdiv'); tmp.style.display='none';;"><?php echo getlang("ยกเลิก::l::Cancel");?></a>
</center></div>

					<?php  
					foot();?>