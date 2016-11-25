<?php 
	; 
        include ("../inc/config.inc.php");
		head();
	 include("_REQPERM.php");
        mn_lib();
				?>
				<SCRIPT LANGUAGE="JavaScript">
				<!--
					
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
function keydownform(e,tmp,disableenter){
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
    if(keycode == 13 && disableenter==true) return false;
    if(keycode == 17) isCtrlKBPressed=true;
    if(keycode == 16) isShiftKBPressed=true;
    if(keycode == 16) isAltKBPressed=true;
	if(isAltKBPressed==true && isShiftKBPressed == true && isCtrlKBPressed == true) {
		if((keycode >= 65 && keycode <=90) || (keycode >= 48 && keycode <=57)) {
			 //tmp=getobj(setlastfocusstr); 
			 tmps=tmp.value=tmp.value+'^'+String.fromCharCode(keycode).toLowerCase();
		}
		return false;
	}
    if(keycode == 82 && isCtrlKBPressed == true) {
		//ctrl+R
         //eval(KB_CTRL_Rdb[setlastfocusstr_tag]);
         return false;
    }
    if(keycode == 83 && isCtrlKBPressed == true) {
		//ctrl+S
         return false;
    }

}
				//-->
				</SCRIPT>
				
				<script>
				startrunning=0
				</script><?php 
			pagesection(getlang("คีย์รายการใหม่แบบง่าย::l::Easy Key new"));
//echo $fpath;
if ($lastitem!="") {
	?><TABLE width="1000" border="0" cellspacing="1" cellpadding="3" align=center>
<TR>
	<TD><?php 
  res_brief_dsp($lastitem);	
	?></TD>
</TR>
</TABLE><?php 
}
function local_form($wh,$maxlen) {
	?>
	<INPUT TYPE="text" NAME="<?php  echo $wh;?>" autocomplete=off
	<?php 
	if ($maxlen<50) {
		echo "size=$maxlen maxlength=$maxlen";
	} else {
		echo "size=50";
	}
		echo " maxlength=$maxlen";
	if ($wh=="tag008") {
		echo " value=".(date("Y")+543)."";
	}
	?>>
<?php 
}

?>
<BR>

<SCRIPT LANGUAGE="JavaScript">
<!--

	function FitToContent(text )
{
   //var text = getobj(id);
	if ( !text ) return;
	//alert(1);
	maxHeight=400
	var adjustedHeight = text.clientHeight;
	//alert(adjustedHeight);
	if ( !maxHeight || maxHeight > adjustedHeight ) {
		adjustedHeight = Math.max(text.scrollHeight, adjustedHeight);
		if ( maxHeight ) 
		adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if ( adjustedHeight > text.clientHeight ) {
			text.style.height = adjustedHeight + "px";
			//alert(text.style.height);
		}
	}
}
//-->
</SCRIPT>
<style type="text/css">


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
	
/***********************************************
* Fixed ToolTip script- ? Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
		
var tipwidth='500px' //default tooltip width
var tipbgcolor='lightyellow'  //tooltip bgcolor
var disappeardelay=250  //tooltip disappear speed onMouseout (in miliseconds)
var vertical_offset="0px" //horizontal offset of tooltip from anchor link
var horizontal_offset="-3px" //horizontal offset of tooltip from anchor link

/////No further editting needed
//if (ie||ns6) {
	document.write('<div id="fixedtipdivforsuggest" style="visibility:hidden;width:'+tipwidth+';background-color:'+tipbgcolor+'" ></div>')
//}
	
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
		localdropmenuobj.style.left=localdropmenuobj.style.top=-500;
	if (tipwidth!=""){
		//localdropmenuobj.widthobj=localdropmenuobj.style
		//localdropmenuobj.widthobj.width=tipwidth
	}
	if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
		obj.visibility=visible
	else if (obj.visibility==hidden)
		obj.visibility=visible
	else if (obj.visibility==visible)
		obj.visibility=visible
}
	
function local_iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge, localdropmenuobj){
	var edgeoffset=(whichedge=="rightedge")? parseInt(horizontal_offset)*-1 : parseInt(vertical_offset)*-1
	if (whichedge=="rightedge"){
		var windowedge=ie && !window.opera? local_iecompattest().scrollLeft+local_iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
		localdropmenuobj.contentmeasure=localdropmenuobj.offsetWidth
		if (windowedge-localdropmenuobj.x < localdropmenuobj.contentmeasure)
			edgeoffset=localdropmenuobj.contentmeasure-obj.offsetWidth
	}
	else{
		var windowedge=ie && !window.opera? local_iecompattest().scrollTop+local_iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18;
		localdropmenuobj.contentmeasure=localdropmenuobj.offsetHeight;
		if (windowedge-localdropmenuobj.y < localdropmenuobj.contentmeasure) {
			edgeoffset=localdropmenuobj.contentmeasure+obj.offsetHeight;
		}
	}
	return edgeoffset;
}
	
function showhidesuggestme_justhide() {
dropmenuobjforsuggest=getobj("fixedtipdivforsuggest");
dropmenuobjforsuggest.innerHTML=" ";
dropmenuobjforsuggest.style.visibility="hidden";

}
function fixedtooltipforsuggest(menucontents, obj, e, tipwidth,titletext) {
				 if (titletext==undefined) {
				 		titletext="<?php  echo getlang("เครื่องมือช่วย::l::Related Data");?>";
				 } 
				 //alert(setlastfocusstr);
	laststr="";
				 //alert(laststr);
	//if (window.event) event.cancelBubble=true
	//else if (e.stopPropagation) e.stopPropagation()
	//clearhidetip()
	//dropmenuobjforsuggest=document.getElementById? document.getElementById("fixedtipdivforsuggest") : fixedtipdivforsuggest
	dropmenuobjforsuggest=getobj("fixedtipdivforsuggest");
	dropmenuobjforsuggest.innerHTML=("<TABLE width=100% class=table_border cellpadding=1 cellspacing=0><TR><TD class=table_head width=100% >"+titletext+"</TD><TD width=16 class=table_head style='cursor: hand; cursor: pointer;' ><B onmousedown=\"showhidesuggestme_justhide();\"><img border=0 src='../neoimg/misc/DELETE.GIF'></B></TD></TR>"+"<TR><TD class=table_td colspan=2> <iframe src='"+menucontents+"&laststr="+laststr+"' width=100% height=220 FRAMEBORDER=no BORDER=0 SCROLLING=YES ></iframe></TD></TR></TABLE>");

	if (ie||ns6) {
		showhide(dropmenuobjforsuggest.style, e, "visible", "hidden", tipwidth,dropmenuobjforsuggest)
		dropmenuobjforsuggest.x=getposOffset(obj, "left")
		dropmenuobjforsuggest.y=getposOffset(obj, "top")
		dropmenuobjforsuggest.style.left=dropmenuobjforsuggest.x-clearbrowseredge(obj, "rightedge",dropmenuobjforsuggest)+"px"
		dropmenuobjforsuggest.style.top=dropmenuobjforsuggest.y-clearbrowseredge(obj, "bottomedge",dropmenuobjforsuggest)+obj.offsetHeight+"px"
	}
}
//-->
</SCRIPT><FORM METHOD=POST ACTION="easyadd_action.php">
<TABLE align=center width=1000 class=table_border>

<style>
.localinput {
	width:100%; border: 0px solid #646464;
	border-left-width: 2px;
}
.localinputsmall {
	border: 0px solid #646464;
	border-left-width: 2px;
}
</style>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("ภาษา::l::Language"); ?></TD><TD class=table_td> 
<FONT SIZE="" COLOR="" class=smaller>
	<label><INPUT TYPE="radio" NAME="matlang" value="tha" checked> <?php  echo getlang("ไทย::l::Thai");?></label>
	<label><INPUT TYPE="radio" NAME="matlang" value="eng" > <?php  echo getlang("อังกฤษ::l::English");?></label>
	<label><INPUT TYPE="radio" NAME="matlang" value="|||" > <?php  echo getlang("ไม่ระบุ::l::None");?></label>
	<label><INPUT TYPE="radio" NAME="matlang" value="mul" > <?php  echo getlang("หลายภาษา::l::Multi Language");?></label>
	<label><INPUT TYPE="radio" NAME="matlang" value="sig" > <?php  echo getlang("ภาษาสัญลักษณ์::l::Sign Language");?></label></FONT>
	</TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("ประเภททรัพยากร::l::Bibliographic Level"); ?></TD><TD class=table_td> 
<?php 
$lastbiblevelsession=sessionval_get("lastbiblevelsession");
if ($lastbiblevelsession=="") {
	$lastbiblevelsession="m";
}
?><FONT SIZE="" COLOR="" class=smaller>
	<label><INPUT TYPE="radio" NAME="biblevel" value="m" onclick="localchkdisserialitem();"
	<?php  if ($lastbiblevelsession=="m") { echo " checked";}?>> <?php  echo getlang("หนังสือ / ทรัพยากรอื่น ๆ ::l::Books / Other Materials");?></label>
	<label><INPUT TYPE="radio" NAME="biblevel" value="s" onclick="localchkdisserialitem();"
	<?php  if ($lastbiblevelsession=="s") { echo " checked";}?>> <?php  echo getlang("วารสาร ::l::Serials");?></label>
	<label><INPUT TYPE="radio" NAME="biblevel" value="b" onclick="localchkdisserialitem();"
	<?php  if ($lastbiblevelsession=="b") { echo " checked";}?>> <?php  echo getlang("บทความวารสาร ::l::Serial component part");?></label></FONT>
	</TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("ISBN/ISSN"); ?></TD><TD class=table_td> <TEXTAREA NAME="dat[isbn]" ROWS="1" COLS="" class=localinput onkeyup="FitToContent(this)" style="width: 160px!important" onkeydown=" return keydownform(event,this,false);"><?php  echo ("$loadisbn");?></TEXTAREA></TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("ชื่อเรื่อง::l::Title"); ?> *</TD><TD class=table_td> <INPUT TYPE="text" class=localinput  NAME="dat[title]" onkeydown=" return keydownform(event,this,true);" 
	value="<?php  echo addslashes("$loadtitle");?>"></TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("ชื่อผู้แต่ง::l::Author"); ?></TD><TD class=table_td> <TEXTAREA NAME="dat[auth]" 
	ID=datauth
	ROWS="1" COLS="" class=localinput onkeyup="FitToContent(this)" onkeydown=" return keydownform(event,this);"><?php  echo ("$loadauth");?></TEXTAREA></TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("ผู้แต่งนิติบุคคล::l::Organization"); ?></TD><TD class=table_td> <TEXTAREA NAME="dat[orgauth]" ID="datorgauth" ROWS="1" COLS="" class=localinput onkeyup="FitToContent(this)" onkeydown=" return keydownform(event,this);"></TEXTAREA><BR>
	<div ID="authmainselectordiv" style="display:none;" class=smaller>
   	<?php  echo getlang(" ต้องการให้รายการใดเป็นรายการหลัก::l:: which is the main entry");?>
   	<label class=smaller><input type="radio" name="setauthmain" value="auth" checked="checked" /> <?php  echo getlang("ชื่อผู้แต่ง::l::Author"); ?></label>
   	<label class=smaller><input type="radio" name="setauthmain" value="org"/> <?php  echo getlang("ผู้แต่งนิติบุคคล::l::Organization"); ?></label>
	</div>
		<script>
	  function authmainselectorfunc() {
         tmp1=getobj("datauth");
         tmp2=getobj("datorgauth");
         tmp3=getobj("authmainselectordiv");
         if (mytrim(tmp1.value)!="" && mytrim(tmp2.value)!="") {
            tmp3.style.display="block";
         } else {
            tmp3.style.display="none";
         }
	  }
	  setInterval("authmainselectorfunc();",500);
	</script>

	
	</TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("เลขเรียก::l::Call Number"); ?> *</TD><TD class="table_td smaller"> 	<font class=smaller>
	<?php  echo getlang("DC"); ?><?php 
	echo "<B onclick=\"fixedtooltipforsuggest('$dcrURL/_misc/dclist.php?mid=&tagid=&parentjsid=localcallndc', this, event, '550px','DC - Call number')\" ><img src=\"$dcrURL"."neoimg/calln-dc.png\" border=0 width=16 height=16></B>";
	?> <INPUT TYPE="text" NAME="dat[callcdc]"  size=10 class=localinputsmall ID=localcallndc  onkeydown=" return keydownform(event,this,true);"> 
	<?php  echo getlang("LC"); ?><?php 
	echo "<B onclick=\"fixedtooltipforsuggest('$dcrURL/_misc/lclist.php?mid=&tagid=&parentjsid=localcallnlc', this, event, '550px','LC - Call number')\" ><img src=\"$dcrURL"."neoimg/calln-lc.png\" border=0 width=16 height=16></B>";
	?> <INPUT TYPE="text" NAME="dat[callnlc]"  size=10 class=localinputsmall ID=localcallnlc  onkeydown=" return keydownform(event,this,true);"> 
		<?php  echo getlang("NLM ");
	echo "<B onclick=\"fixedtooltipforsuggest('$dcrURL/_misc/nlmlist.php?mid=&tagid=&parentjsid=localcallnnlm', this, event, '550px','DC - Call number')\" ><img src=\"$dcrURL"."neoimg/calln-nlm.png\" border=0 width=16 height=16></B> ";
 ?>
<INPUT TYPE="text" NAME="dat[callnnlm]"  size=10 class=localinputsmall ID=localcallnnlm  onkeydown=" return keydownform(event,this,true);"> <?php  echo getlang("กำหนดเอง::l::Local"); ?> <?php 
	echo "<B onclick=\"fixedtooltipforsuggest('$dcrURL/_misc/callngenner.php?mid=&tagid=$row[fid]&parentjsid=localcalln&recparentval='+(getobj('localcalln').value), this, event, '550px','". getlang("Running เลขเรียก::l::Running Call Number")."')\" ><img src=\"$dcrURL"."neoimg/localcalln.png\" border=0 width=16 height=16></B>";;
	?> <INPUT TYPE="text" NAME="dat[callnlocal]" size=10 class=localinputsmall ID="localcalln"  onkeydown=" return keydownform(event,this,true);"></font>
	</TD>
</TR>
<TR valign=top>
	<TD  class="table_td smaller"><?php  echo getlang("พิมพ์ลักษณ์::l::Imprint"); ?> *</TD><TD class=table_td> <font class=smaller>
	<?php  echo getlang("เมืองพิมพ์::l::City"); ?> <INPUT TYPE="text" NAME="dat[publisher]" class=localinputsmall onkeydown=" return keydownform(event,this,true);">
	<?php  echo getlang("สำนักพิมพ์::l::Publisher"); ?> <INPUT TYPE="text" NAME="dat[publocate]" class=localinputsmall onkeydown=" return keydownform(event,this,true);">
	 <?php  echo getlang("ปีพิมพ์::l::Publishing year"); ?> <INPUT TYPE="text" NAME="dat[pub]"  class=localinputsmall size=4 maxlength=4 onkeydown=" return keydownform(event,this,true);"></font>
	
	</TD>
</TR>
<TR valign=top>
	<TD  class="table_td "><?php  echo getlang("รูปเล่ม::l::Physical"); ?> *</TD><TD class=table_td> 
	<font class=smaller><?php  echo getlang("ครั้งที่พิมพ์::l::Page"); ?> <INPUT TYPE="text" NAME="dat[edition]" class=localinputsmall size=4 onkeydown=" return keydownform(event,this,true);">
	<?php  echo getlang("จำนวนหน้า::l::Page"); ?> <INPUT TYPE="text" NAME="dat[page]" class=localinputsmall size=4 onkeydown=" return keydownform(event,this,true);">
	<?php  echo getlang("ความสูง::l::Height"); ?> <INPUT TYPE="text" NAME="dat[height]" size=4 class=localinputsmall onkeydown=" return keydownform(event,this,true);">
	<?php  echo getlang("ราคา::l::Price"); ?> <INPUT TYPE="text" NAME="dat[price]" size=4 class=localinputsmall onkeydown=" return keydownform(event,this,true);" >
	
<BR>
<?php 
$bibphysicaldesctext=getval("catconfig","bibphysicaldesctext");
$bibphysicaldesctext=explodenewline($bibphysicaldesctext);
$bibphysicaldesctext=arr_filter_remnull($bibphysicaldesctext);
//printr($bibphysicaldesctext);
@reset($bibphysicaldesctext);
while (list($bibphysicaldesctextk,$bibphysicaldesctextv)=each($bibphysicaldesctext)) {
   echo "<label><input type=checkbox name='dat[bibphysicaldescr][]' value='".addslashes($bibphysicaldesctextv)."'>".stripslashes($bibphysicaldesctextv)."</label> ";
}
?>
	</font>
	
	</TD>
</TR>
<TR valign=top>
	<TD class=table_td><br><?php  echo getlang("หัวเรื่อง::l::Subject"); ?></TD><TD class=table_td> 
	<table width=100%>
	<tr>
		<td class="smaller2 table_td"  width=25% align=center>หัวเรื่องใหญ่</td>
		<td class="smaller2 table_td"  width=25% align=center>หัวเรื่องย่อย</td>
		<td class="smaller2 table_td"  width=25% align=center>หัวเรื่องย่อยตามลำดับเวลา</td>
		<td class="smaller2 table_td"  width=25% align=center>หัวเรื่องย่อยทางภูมิศาสตร์</td>
	</tr>
	</table>
		<?php for ($subji=1;$subji<=20;$subji++) {?>
		<span ID="multiplysubj_<?php  echo $subji;?>" style="<?php 
		if ($subji!=1) {
			echo "display:none;";
		}
		?>"><!-- 
			<?php  echo $subji;?> --><table width=100%>
	<tr>
		<td class="smaller2"  width=25% align=center><input type="text" name="dat[subj][]"  style="width:100%" onkeydown="return subjkeydown(event,this);" ID="mainsubm_<?php  echo $subji;?>"></td>
		<td class="smaller2"  width=25% align=center><input type="text" name="dat[subj2][]" style="width:100%" onkeydown="return subjkeydown(event,this);"></td>
		<td class="smaller2"  width=25% align=center><input type="text" name="dat[subj3][]" style="width:100%" onkeydown="return subjkeydown(event,this);"></td>
		<td class="smaller2"  width=25% align=center><input type="text" name="dat[subj4][]" style="width:100%" onkeydown="return subjkeydown(event,this);"></td>
	</tr>
	</table>
		</span>
		<?php }?>
	<!-- <TEXTAREA NAME="dat[subj]" ROWS="1" COLS="" class=localinput onkeyup="FitToContent(this)" onkeydown=" return keydownform(event,this);"></TEXTAREA>--></TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("โน๊ตย่อ::l::Note"); ?></TD><TD class=table_td> <TEXTAREA NAME="dat[note]" ROWS="1" COLS="" class=localinput onkeyup="FitToContent(this)" onkeydown=" return keydownform(event,this);"></TEXTAREA></TD>
</TR>

		<tr>
			<td>
				<?php  echo getlang("ประเภทวัสดุ::l::Material type"); ?></td>
			<td><?php 
			$defrestype=getval("config","defaultresource_code");
			$defrestypesess=sessionval_get("lastrestourcetypeitem");
			if ($defrestypesess!="") {
				 $defrestype=$defrestypesess;
			}
			frm_restype("RESOURCE_TYPE", $defrestype,"NO");
			?></td></tr>
		  <tr>
			<td>
				<?php  echo getlang("วัสดุของห้องสมุด::l::At Library campus"); ?></td>
			<td><?php 
			frm_libsite("FLIBSITE");
		?></td></tr>
<tr>
<td>
	<?php  echo getlang("สถานที่จัดเก็บ::l::Shelve"); ?></td>
<td>
<?php 
//print_r($editing);
$defresplacesess=sessionval_get("lastrestourceplaceitem");
frm_itemplace("itemplace",$defresplacesess);
?>
</td></tr>
<tr>
<td>
	<?php  echo getlang("สถานะ::l::Status"); ?></td>
<td>
<?php 
//print_r($editing);
$defstatussess=sessionval_get("defstatussess");
frm_genlist("status","select * from media_mid_status order by code","code","name","-localdb-","yes",$defstatussess);
?>
</td></tr>
<SCRIPT LANGUAGE="JavaScript">
<!--
currentsubjdisplay=1;
function subjkeydown(e,wh) {
	if(window.event) {// IE
		keynum = e.keyCode;
	} else if(e.which) {// Netscape/Firefox/Opera
		keynum = e.which;
	}
	//alert(keynum);

	if (keynum==13) {
		currentsubjdisplay=currentsubjdisplay+1
		//alert(currentsubjdisplay);
		if (currentsubjdisplay<=20)
		{
			tmp=getobj("multiplysubj_"+currentsubjdisplay);
			tmp.style.display="block";
			tmp=getobj("mainsubm_"+currentsubjdisplay);
			tmp.focus();
		}
		return false;
	} else {
		return true;	
	}
}
function localbckeydown_localthisfile(e,wh) {
	if(window.event) {// IE
     keynum = e.keyCode;
  } else if(e.which) {// Netscape/Firefox/Opera
    keynum = e.which;
  }
	//alert(keynum);

	if (keynum==13) {
		 //wh.value=wh.value+','
		 return true;
	}

	if (keynum==36 || keynum==8 || keynum==35 || keynum==37 || keynum==38 || keynum==39 || keynum==40 || keynum==188) {
		 return true;
	}
	if ((keynum>=48 && keynum<=57) || (keynum<=105&&keynum>=96)) {
		
		return true;
	}
	return false;
}
//-->
</SCRIPT>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("กรอกบาร์โค้ด::l::Enter Barcode"); ?></TD>
	<TD class=table_td>

	
		<div id=barcodecontainterdivserialdis style='display:none;'>
		<?php html_dialog("",getlang("ไม่สามารถเพิ่มไอเทมวารสารในโมดูลนี้ได้::l::Cannot add serial item at this module"));?>
		</div>

	<div id=barcodecontainterdiv >
	<TABLE cellpadding=0 cellspacing=0 width=100%>
    <tr bgcolor = "#f3f3f3">
      <td  colspan=1>
<script>
function timeoutman(wh,whthis) {
if (whthis.timeoutvalue!=undefined) {
  clearTimeout(whthis.timeoutvalue);
}
	whthis.timeoutvalue=setTimeout("getobj('"+wh+"').src='bccheck.php?bc="+whthis.value+"';",1000);
	//alert("getobj('"+wh+"').src='bccheck.php?bc="+whthis.value+"';");
}
</script>
<TABLE cellpadding=0 cellspacing=0 width=100%>
	  <TR valign=top>
		<TD><span ID="BCRESULT"></span></TD>
		<TD>
		<span ID="BCSOURCE" >
		<nobr class=smaller2>
	<?php  echo getlang("เลขทะเบียน::l::Code"); ?> <input type = text name="REPLACETABEAN[]" ID="tabean[RANDOMHERE]" onkeydown="return localbckeydown2(event,this);" class=smaller style="width:90">
		<img border=0 align=absmiddle src="<?php  echo $dcrURL?>neoimg/Left16.gif" style="cursor: hand; cursor: pointer;" 
		onclick="getobj('tabean[RANDOMHERE]').value=getobj('text[RANDOMHERE]').value"> 
		Barcode <input type = text ID="text[RANDOMHERE]" name = "REPLACETHIS[]" 
		onkeydown="return localbckeydown(event,this);"
		onkeyup="timeoutman('bcchecker[RANDOMHERE]',this);"	
		onmousedown="getobj('bcchecker[RANDOMHERE]').src='bccheck.php?bc='+this.value;return true;"			
		style="width:110" class=smaller autocomplete=off>

		<?php  echo getlang("ฉบับ::l::Copy"); ?>
			<input type = text name="REPLACEINUMMER[]" value="" ID="inumber[RANDOMHERE]" onkeydown="return localbckeydown2(event,this);" size=4 class=smaller>
			<iframe src="" width=125 height=25 frameborder=0 SCROLLING=NO ID='bcchecker[RANDOMHERE]'></iframe>
			</nobr>
		</span>
		</TD>
	  </TR></TABLE>
		

	<?php 
		include("./local.bcjsfunc.php");
	?>
	<!-- 
	  <TR valign=top>
		<TD><TEXTAREA NAME="ITEMBARCODE" ROWS="1" COLS="" class=localinput 
 onblur="getobj('bcchecker').src='bccheck_easy.php?bc='+escape(this.value);"
onkeyup="FitToContent(this);getobj('bcchecker').src='bccheck_easy.php?bc='+escape(this.value);" style="width: 200px!important" onkeydown="keydownform(event,this);return localbckeydown_localthisfile(event,this);"></TEXTAREA><?php 
		$_bcjsfunc_skipmulti="yes";
		include("local.bcjsfuncsmall.php");
		
		?></TD>
		<TD><iframe src="" width=250 height=100 frameborder=0 SCROLLING=NO ID='bcchecker'></iframe></TD>
	  </TR> -->
</TD>
</TR>
</TABLE>
</div>
</TD></TR>
<TR>
	<TD colspan=2 align=center><TABLE width=600 >
	<TR>
	<TD class="table_head smaller"><?php  echo getlang("เผยแพร่ Bib นี้::l::Publish this bib");?></TD>
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
	<?php  if ($x[ispublish]=="yes") { echo " checked ";}	?>
	><?php  echo getlang("เผยแพร่::l::Publish");?></label>
	<label style="color:darkred"  class=smaller2><INPUT TYPE="radio" NAME="ispublish" value="no" 	
	<?php  if ($x[ispublish]!="yes") { echo " checked ";}	?>
><?php  echo getlang("ไม่เผยแพร่::l::Not publish");?></label>
<?php 
} else {
	if ($x[ispublish]=="") {
		$x[ispublish]="no";
	}
	?><input type="hidden" name="ispublish" value="<?php  echo $x[ispublish]?>"><?php  echo getlang("ไม่เผยแพร่::l::Not publish");?><?php 
}
	?>
	</TD>
</TR>
</TABLE>
	</TD>
</TR>
<TR>
	<TD colspan=2 align=center><FONT SIZE="" COLOR="" class=smaller2>* <?php echo getlang("ไม่สามารถเพิ่มได้หลายรายการ::l::Cannot add multiple line");?></FONT><BR><INPUT TYPE="submit" value="  Submit  "> 
	<A HREF="DBbook.php" class=a_btn><B><?php  echo getlang("กลับ::l::Back");?></B></A>
	</TD>
</TR>

</TABLE>
	<script>
	function localchkdisserialitem() {
      var radios = document.getElementsByName('biblevel');
      biblevelval="";
      for (var i = 0, length = radios.length; i < length; i++) {
       if (radios[i].checked) {
           // do whatever you want with the checked radio
           biblevelval=radios[i].value;

           // only one radio can be logically checked, don't check the rest
           break;
       }
      }
	  bcdivsa=getobj("barcodecontainterdivserialdis");
	  bcdivs=getobj("barcodecontainterdiv");
      if (biblevelval=="s") {
         bcdivsa.style.display="block";
         bcdivs.style.display="none";
      } else {
         bcdivsa.style.display="none";
         bcdivs.style.display="block";
      }
	}
	localchkdisserialitem();
	</script>
	
</FORM><BR><BR>
<?php  foot();
?>