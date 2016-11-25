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
function keydownform(e,tmp){
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
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
				startrunning=1
				</script><?php 
			pagesection(getlang("คีย์รายการใหม่แบบง่าย::l::Easy Key new"));
//echo $fpath;
if ($lastitem!="") {
	?><TABLE width="770" border="0" cellspacing="1" cellpadding="3" align=center>
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
<TABLE align=center width=780 class=table_border>
<FORM METHOD=POST ACTION="easyadd_action.php">

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
		
var tipwidth='150px' //default tooltip width
var tipbgcolor='lightyellow'  //tooltip bgcolor
var disappeardelay=250  //tooltip disappear speed onMouseout (in miliseconds)
var vertical_offset="0px" //horizontal offset of tooltip from anchor link
var horizontal_offset="-3px" //horizontal offset of tooltip from anchor link

/////No further editting needed
if (ie||ns6) {
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
	
function showhidesuggestme_justhide() {
	dropmenuobjforsuggest=document.getElementById? document.getElementById("fixedtipdivforsuggest") : fixedtipdivforsuggest
	dropmenuobjforsuggest.innerHTML="";
	dropmenuobjforsuggest.style.visibility="hidden"
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
	dropmenuobjforsuggest=document.getElementById? document.getElementById("fixedtipdivforsuggest") : fixedtipdivforsuggest
	dropmenuobjforsuggest.innerHTML="<TABLE width=100% class=table_border cellpadding=1 cellspacing=0><TR><TD class=table_head width=100%>"+titletext+"</TD><TD width=16 class=table_head style='cursor:hand;' ><B onmousedown='showhidesuggestme_justhide();'><img border=0 src='../neoimg/misc/DELETE.GIF'></B></TD></TR>"+
	"<TR>	<TD class=table_td colspan=2><iframe src='"+menucontents+"&laststr="+(laststr)+"' width=100% height=220 FRAMEBORDER='no' BORDER=0 SCROLLING=YES ></iframe></TD>	</TR></TABLE>";

	if (ie||ns6) {
		showhide(dropmenuobjforsuggest.style, e, "visible", "hidden", tipwidth,dropmenuobjforsuggest)
		dropmenuobjforsuggest.x=getposOffset(obj, "left")
		dropmenuobjforsuggest.y=getposOffset(obj, "top")
		dropmenuobjforsuggest.style.left=dropmenuobjforsuggest.x-clearbrowseredge(obj, "rightedge",dropmenuobjforsuggest)+"px"
		dropmenuobjforsuggest.style.top=dropmenuobjforsuggest.y-clearbrowseredge(obj, "bottomedge",dropmenuobjforsuggest)+obj.offsetHeight+"px"
	}
}
//-->
</SCRIPT>
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
	<label><INPUT TYPE="radio" NAME="biblevel" value="m" 
	<?php  if ($lastbiblevelsession=="m") { echo " checked";}?>> <?php  echo getlang("หนังสือ / ทรัพยากรอื่น ๆ ::l::Books / Other Materials");?></label>
	<label><INPUT TYPE="radio" NAME="biblevel" value="s"
	<?php  if ($lastbiblevelsession=="s") { echo " checked";}?>> <?php  echo getlang("วารสาร ::l::Serials");?></label>
	<label><INPUT TYPE="radio" NAME="biblevel" value="b"
	<?php  if ($lastbiblevelsession=="b") { echo " checked";}?>> <?php  echo getlang("บทความวารสาร ::l::Serial component part");?></label></FONT>
	</TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("ISBN"); ?></TD><TD class=table_td> <TEXTAREA NAME="dat[isbn]" ROWS="1" COLS="" class=localinput onkeyup="FitToContent(this)" style="width: 160px!important" onkeydown=" return keydownform(event,this);"><?php  echo ("$loadisbn");?></TEXTAREA></TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("ชื่อเรื่อง::l::Title"); ?> *</TD><TD class=table_td> <INPUT TYPE="text" class=localinput  NAME="dat[title]" onkeydown=" return keydownform(event,this);" 
	value="<?php  echo addslashes("$loadtitle");?>"></TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("ชื่อผู้แต่ง::l::Author"); ?></TD><TD class=table_td> <TEXTAREA NAME="dat[auth]" ROWS="1" COLS="" class=localinput onkeyup="FitToContent(this)" onkeydown=" return keydownform(event,this);"><?php  echo ("$loadauth");?></TEXTAREA></TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("ผู้แต่งนิติบุคคล::l::Organization"); ?></TD><TD class=table_td> <TEXTAREA NAME="dat[orgauth]" ROWS="1" COLS="" class=localinput onkeyup="FitToContent(this)" onkeydown=" return keydownform(event,this);"></TEXTAREA></TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("เลขเรียก::l::Call Number"); ?> *</TD><TD class="table_td smaller"> 	<font class=smaller>
	<?php  echo getlang("DC"); ?><?php 
	echo "<B onclick=\"fixedtooltipforsuggest('../_misc/dclist.php?mid=&tagid=&parentjsid=localcallndc', this, event, '550px','DC - Call number')\" ><img src=\"$dcrURL"."neoimg/calln-dc.png\" border=0 width=16 height=16></B>";
	?> <INPUT TYPE="text" NAME="dat[callcdc]"  size=10 class=localinputsmall ID=localcallndc  onkeydown=" return keydownform(event,this);"> 
	<?php  echo getlang("LC"); ?><?php 
	echo "<B onclick=\"fixedtooltipforsuggest('../_misc/lclist.php?mid=&tagid=&parentjsid=localcallnlc', this, event, '550px','LC - Call number')\" ><img src=\"$dcrURL"."neoimg/calln-lc.png\" border=0 width=16 height=16></B>";
	?> <INPUT TYPE="text" NAME="dat[callnlc]"  size=10 class=localinputsmall ID=localcallnlc  onkeydown=" return keydownform(event,this);"> 
		<?php  echo getlang("NLM "); ?>
<INPUT TYPE="text" NAME="dat[callnnlm]"  size=10 class=localinputsmall ID=localcallnnlm  onkeydown=" return keydownform(event,this);"> <?php  echo getlang("กำหนดเอง::l::Local"); ?> <?php 
	echo "<B onclick=\"fixedtooltipforsuggest('../_misc/callngenner.php?mid=&tagid=$row[fid]&parentjsid=localcalln&recparentval='+(getobj('localcalln').value), this, event, '550px','". getlang("Running เลขเรียก::l::Running Call Number")."')\" ><img src=\"$dcrURL"."neoimg/localcalln.png\" border=0 width=16 height=16></B>";;
	?> <INPUT TYPE="text" NAME="dat[callnlocal]" size=10 class=localinputsmall ID="localcalln"  onkeydown=" return keydownform(event,this);"></font>
	</TD>
</TR>
<TR valign=top>
	<TD  class="table_td smaller"><?php  echo getlang("พิมพ์ลักษณ์::l::Imprint"); ?> *</TD><TD class=table_td> <font class=smaller>
	<?php  echo getlang("สำนักพิมพ์::l::Publisher"); ?> <INPUT TYPE="text" NAME="dat[publisher]" class=localinputsmall>
	<?php  echo getlang("เมืองพิมพ์::l::City"); ?> <INPUT TYPE="text" NAME="dat[publocate]" class=localinputsmall>
	<?php  echo getlang("ปีพิมพ์::l::Publishing year"); ?> <INPUT TYPE="text" NAME="dat[pub]" size=4 maxlength=4 class=localinputsmall></font>
	
	</TD>
</TR>
<TR valign=top>
	<TD  class="table_td "><?php  echo getlang("รูปเล่ม::l::Physical"); ?> *</TD><TD class=table_td> 
	<font class=smaller><?php  echo getlang("ครั้งที่พิมพ์::l::Page"); ?> <INPUT TYPE="text" NAME="dat[edition]" class=localinputsmall size=4>
	<?php  echo getlang("จำนวนหน้า::l::Page"); ?> <INPUT TYPE="text" NAME="dat[page]" class=localinputsmall size=4>
	<?php  echo getlang("ความสูง::l::Height"); ?> <INPUT TYPE="text" NAME="dat[height]" size=4 class=localinputsmall >
	<?php  echo getlang("ราคา::l::Price"); ?> <INPUT TYPE="text" NAME="dat[price]" size=4 class=localinputsmall >
	
	</font>
	
	</TD>
</TR>
<TR valign=top>
	<TD class=table_td><?php  echo getlang("หัวเรื่อง::l::Subject"); ?></TD><TD class=table_td> <TEXTAREA NAME="dat[subj]" ROWS="1" COLS="" class=localinput onkeyup="FitToContent(this)" onkeydown=" return keydownform(event,this);"></TEXTAREA></TD>
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
			frm_restype("RESOURCE_TYPE", $defrestype);
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
<SCRIPT LANGUAGE="JavaScript">
<!--
	
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
	<TD class=table_td><TABLE cellpadding=0 cellspacing=0 width=100%>
	  <TR valign=top>
		<TD><TEXTAREA NAME="ITEMBARCODE" ROWS="1" COLS="" class=localinput 
 onblur="getobj('bcchecker').src='bccheck_easy.php?bc='+escape(this.value);"
onkeyup="FitToContent(this);getobj('bcchecker').src='bccheck_easy.php?bc='+escape(this.value);" style="width: 200px!important" onkeydown="keydownform(event,this);return localbckeydown_localthisfile(event,this);"></TEXTAREA><?php 
		$_bcjsfunc_skipmulti="yes";
		include("local.bcjsfuncsmall.php");
		
		?></TD>
		<TD><iframe src="" width=250 height=100 frameborder=0 SCROLLING=NO ID='bcchecker'></iframe></TD>
	  </TR>
	  </TABLE></TD>
</TR>

<TR>
	<TD colspan=2 align=center><FONT SIZE="" COLOR="" class=smaller2>* <?php echo getlang("ไม่สามารถเพิ่มได้หลายรายการ::l::Cannot add multiple line");?></FONT><BR><INPUT TYPE="submit" value="  Submit  "> 
	<A HREF="DBbook.php" class=a_btn><B><?php  echo getlang("กลับ::l::Back");?></B></A>
	</TD>
</TR>
</FORM>
</TABLE>
<BR><BR>
<?php  foot();
?>