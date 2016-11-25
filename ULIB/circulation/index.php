<?php 
	; 
	include ("../inc/config.inc.php");
	//head();
	include("./_REQPERM.php");

   if ($qrcodereader=="on") {
      sessionval_set("qrcodereader","on");
   }
   if ($qrcodereader=="off") {
      sessionval_set("qrcodereader","off");
   }
	html_start();
	mn_lib();
?>
<TABLE WIDTH=1000 ALIGN=CENTER BORDER=0 CELLPADDING=0 CELLSPACING=0 >
<TR>
<TD COLSPAN=2 align=center ID="CIR_TOPBARMENU">
<?php 
html_xpbtn(getlang("ข้อมูลไอเทมวัสดุ::l::Media item").",working.midinfo.php,lightgray,working"
."::".getlang("ผู้ใช้ล่าสุด::l::Recent member").",working.recentmember.php,lightgray,working"
."::".getlang("ค่าปรับ::l::Fine List").",working.finelist.php,lightgray,working"
."::".getlang("ประวัติค่าปรับ::l::Fine History").",working.finehistlist.php,lightgray,working"
."::".getlang("รายการจอง::l::Request List").",working.rq.php,lightgray,working"
."::".getlang("รับหนังสือจอง::l::Pickup").",working.rq.php?filter=yes,lightgray,working"
."::".getlang("หาย::l::Losted").",working.lost.php,lightgray,working"
."::".getlang("ขอยืม::l::Request").",working.request_list.php,lightgray,working"
);
?>
</TD>
</TR>
<TR>
<TD><IFRAME HEIGHT=150 WIDTH=300 frameborder=1 SCROLLING=NO src="<?php 
if ($loadfine=="") {
	echo "main.checkout.php";
} else {
	echo "main.fine.php?memberbarcode=$loadfine&loadremotefine=yes&skipalertfine=$skipalertfine";
}
?>" name="main" ID="main"></IFRAME></TD>
<TD><IFRAME HEIGHT=150 WIDTH=696 frameborder=1 SCROLLING=NO name="display" ID="display"></IFRAME></TD>
</TR>
</TABLE>
<TABLE WIDTH=780 ALIGN=CENTER BORDER=0 CELLPADDING=0 CELLSPACING=0>
<TR>
<TD COLSPAN=2><IFRAME HEIGHT=450 WIDTH=1000 frameborder=1 SCROLLING=AUTO name="working" ID="working" src="<?php 
if ($loadfine=="") {
} else {
	echo "working.fine.php?memberbarcode=$loadfine&skipalertfine=$skipalertfine";
}
?>"></IFRAME></TD>
</TR></TABLE>

<style>
#webintropage {
	z-index: 10001;

    margin: 0px 0px 0px 0px;
	/*background-color:#ffffff;*/
	position: fixed; top:0px; left:0px; width:100%; height:100%; color:#FFFFFF; 
	text-align: center; 
	vertical-align: middle;
}
</style>
<script>
var cirpagealert_to;
function cirpagealert_show(wh){
	var dspdiv=getobj('cir_mainalertDIV');
	dspdiv.innerHTML=wh;
	var thediv=getobj('cirpagealertbg');
	thediv.style.display = "table";
	var thediv=getobj('cirpagealert');
	thediv.style.display = "table";
	cirpagealert_to = setTimeout(function(){cirpagealert_hide()},2500);
	return true;
	//
}
function cirpagealert_hide(){
   clearTimeout(cirpagealert_to);
	var thediv=getobj('cirpagealertbg');
	thediv.style.display = "none";
	var thediv=getobj('cirpagealert');
	thediv.style.display = "none";
	return true;
}
</script>

<div id="cirpagealertbg" onclick='return cirpagealert_hide();' 
style="display: none;  height: 100%;  position: absolute;  overflow: hidden;  width: 100%;z-index: 10000; top: 0px; left: 0px;
	filter: alpha(opacity=90); 	filter:progid:DXImageTransform.Microsoft.Alpha(opacity=90); -moz-opacity: .90; 	-khtml-opacity: 0.9; opacity: 0.9; background-color: #FFCCA7">&nbsp;
</div>
<div id="cirpagealert" style="top:0px; left: 0px; display: none; height: 100%; z-index: 10001; position: absolute;  overflow: hidden;  width: 100%;" 
onclick='return cirpagealert_hide();'>
   <div style="display: table-cell;  vertical-align: middle; ">
    <div style="margin:0 auto 0 auto;  text-align:center; display: block; width: 100%; height: 100px;">
      <div  onclick='return cirpagealert_hide();' ID="cir_mainalertDIV" align=center style="position: absolute;; display:block; width: 500px; height: 100px; 
      left: calc((100%/2) - 250px); top: calc((100%/2) - 50px); border: 1px solid white; vertical-align: middle; line-height: 100px;
      font-weight: bold; font-size: 22px; color: darkred;
      background-image: url(../neoimg/alpha90.png);
      -webkit-box-shadow: 0px 0px 30px 0px rgba(50, 50, 50, 0.75);
-moz-box-shadow: 0px 0px 30px 0px rgba(50, 50, 50, 0.75);
box-shadow: 0px 0px 30px 0px rgba(50, 50, 50, 0.75);
      ">
    
      </div>

   </div>
 </div>
</div>
<script>
var lastqrreaded="";
var lastqrreadedtimeoutid;
function local_clearlastqr() {
   lastqrreaded="";
   console.log("local_clearlastqr()");
}
</script>
<?php
if (strtolower(barcodeval_get("personalsetting-o-mainmenuswitchtabmode-$useradminid"))=="yes" || sessionval_get("qrcodereader")=="on") {
   
   form_qrreader("
   if (lastqrreaded==data) {  
      console.log(\"skip qr \"+data);
      return; 
   }
   console.log(\"processqr \"+data);
   lastqrreaded=data;
   tmp=getobj(\"main\");
   var ifr = document.getElementById( \"main\" );
   var ifrDoc = ifr.contentDocument || ifr.contentWindow.document;
   var theForm = ifrDoc.forms[0];
   var theFormel = ifrDoc.forms[0].elements[0];
   theFormel.value=data;
   theForm.submit();
   //tmp.src=\"main.checkout.php?memberbarcode=\"+data;
   clearTimeout(lastqrreadedtimeoutid);
   lastqrreadedtimeoutid=setTimeout(\"local_clearlastqr();\",5000);
   
   ");
   if (strtolower(barcodeval_get("personalsetting-o-mainmenuswitchtabmode-$useradminid"))!="yes") {
   ?><center><a href='index.php?qrcodereader=off'>Turn off QR code reader</a></center><?php
   }
   ?>
<?php
} else {
   ?><center><a href='index.php?qrcodereader=on'>Turn on QR code reader</a></center>
<?php
}
?>

<?php 
	foot();
?>