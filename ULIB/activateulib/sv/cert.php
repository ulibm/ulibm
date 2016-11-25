<?php  //พ
include("../../inc/config.inc.php");
include("./_conf.php");
$now=time();
html_start();

if ($certid=="") {
	 html_dialog("Error","Invalid Certification ID");
	 die;
}
$refcode1=strtoupper(substr($certid,0,5));
		$refcode2=substr($certid,-2);
		if ($refcode1=="" || $refcode2=="") {
			 die("refcode is empty");
		}
		
		$s=tmq("select * from ulibsv	where refcode='$refcode1' and refordr='$refcode2' ");
		if (tmq_num_rows($s)!=1) {
				html_dialog("Error","Error, Certification ID found, ($certid)");
					die;
		}
		
		$s=tmq_fetch_array($s);
?><table width=450 height=300 cellpadding=0 cellspacing=0 border=0 background="cert.png" align=center>
<tr valign=top><td style="padding-top: 50px;padding-left: 50px;padding-right: 50px; padding-bottom: 0;" align=middle>
<span style="font-size: 20px; font-family: Tahoma; color: #330033">
<?php 
if ($s[isallowed]=="yes") {
	echo "License Certification";
} else {
	echo "License Certification (<u>unconfirmed</u>)";
}
?></span><br />
<div style="padding-top: 10px; font-size: 10px; font-family: Tahoma; color: #000000; ">
for</div>
<div style="padding-top: 10px; font-size: 14px; font-family: Tahoma; color: #000000; font-weight: bold;">
<?php 
echo $s[orgname_eng];
?></div>
<div style="padding-top: 10px;font-size: 10px; font-family: Tahoma; color: #555555; font-weight: normal;"><br />

This licensed is under the terms of the User License Agreement
</div>
<div style="font-size: 10px; font-family: Tahoma; color: #000000; font-weight: normal;"><br />
by<br />

Union Library Management (ULIBM) Developer team</div>
</td></tr>

<tr valign=top height=65><td>
<div style="padding-right: 50px; text-align:right; font-size: 10px; font-family: Tahoma; color: #444; font-weight: normal;">
Certid:<b style="font-size: 10px;"><?php 
echo $certid;
?></b><br />
 <span style="font-size: 9px;">This certificate generated automatically</span></div>
</td></tr>

</table>













<script language=JavaScript>
<!--

//Disable right click script III- By Renigade (renigade@mediaone.net)
//For full source code, visit http://www.dynamicdrive.com

var message="";
///////////////////////////////////
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if 
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers) 
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}

document.oncontextmenu=new Function("return false")
// --> 
</script>

<script type="text/javascript">

/***********************************************
* Disable Text Selection script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

function disableSelection(target){
if (typeof target.onselectstart!="undefined") //IE route
	target.onselectstart=function(){return false}
else if (typeof target.style.MozUserSelect!="undefined") //Firefox route
	target.style.MozUserSelect="none"
else //All other route (ie: Opera)
	target.onmousedown=function(){return false}
target.style.cursor = "default"
}

//Sample usages
disableSelection(document.body) //Disable text selection on entire body
//disableSelection(document.getElementById("mydiv")) //Disable text selection on element with id="mydiv"

</script>
