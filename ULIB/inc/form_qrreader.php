<?php
function form_qrreader($code) {
   //use data in code for qr variable
global $dcrURL;
?>
<script src="<?php echo $dcrURL?>_misc/qrcodereader/jquery-1.9.1.min.js"></script>
<script src="<?php echo $dcrURL?>_misc/qrcodereader/html5-qrcode.min.js"></script>
<script>
    function getobj(the_id) {

	if (typeof the_id != 'string') {
		return the_id;
	}

	if (typeof document.getElementById != 'undefined') {
		return document.getElementById(the_id);
	} else if (typeof document.all != 'undefined') {
		return document.all[the_id];
	} else if (typeof document.layers != 'undefined') {
		return document.layers[the_id];
	} else {
		return null;
	}
}

    $(document).ready(function(){
	$('#reader').html5_qrcode(function(data){
			tmp=getobj("read");
			if (tmp.innerHTML==data) {
   			document.body.style.background = "#660000";
            setTimeout("localrestorebg();",100);
         } else {
            document.body.style.background = "#000000";
            setTimeout("localrestorebg();",100);
            tmp.innerHTML=data
            setTimeout("localrestorebc();",3000);
            ///start arg 
            <?php 
            echo stripslashes($code);
            ?>
            ///end ard
            Console.log("QR-READ:"+data);
         }
         //$('#read').html(data);
         //tmp.innerHTML=data;
		},
		function(error){
			$('#read_error').html(error);
		}, function(videoError){
			$('#vid_error').html(videoError);
		}
	);
});

function localrestorebg() {
   document.body.style.background = "#ffffff";
}
function localrestorebc() {
   tmp2=getobj("read");
   tmp2.innerHTML="-";
}
qrujsw=500;
qrujsh=285;
</script>

<a href="javascript:void(null);" 
onclick="tmp=getobj('qrreader_full'); if (tmp.style.display=='none') { tmp.style.display='block'; } else { tmp.style.display='none'; } tmp2=ulibjs_getOffset(tmp); <?php
?> if (tmp2.top<0) {tmp.style.top='0px';}"
><img src="<?php echo $dcrURL?>_misc/qrcodereader/glass.gif" width=18 height=18 border=0 TITLE="Scanning QR-Code"></a>

<div style="position:absolute; height: auto;">

<div ID="qrreader_full" 
style="display:none; position: fixed; top: -250px; left: 20px; width: 500px; height: 285px; background-color: white; border: 2px solid #eeeeee;
margin-left: 0px;

-webkit-box-shadow: 0px 0px 25px 0px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 0px 25px 0px rgba(0,0,0,0.75);
box-shadow: 0px 0px 25px 0px rgba(0,0,0,0.75);
">
		<table width=100%>
		 <tr><td width=10><img src='<?php echo $dcrURL;?>webbox/mnset1.gif' border=0 onclick="localqrmnset(1);" style='cursor: hand; cursor: pointer;;'></td><td></td><td width=10><img src='<?php echo $dcrURL;?>webbox/mnset2.gif' border=0 onclick="localqrmnset(2);" style='cursor: hand; cursor: pointer;;'></td></tr>
		 <tr><td></td><td>
		 
		 

		
		
   <table width=100% border=0 cellpadding=0 cellspacing=0> <tr valign=top>
    
    <td width=250 bgcolor=#000000><div  class="center" id="reader" style="width:300px;height:250px;"></div></td>
    
    <td>
    <span class="center"><b>Result:</b></span>
<span id="read" class="center" style="font-size:20px;">-</span>
<br>
<div style="display:block; color: #cccccc">
<span class="center smaller" style="text-decoration: underline;">Read Error (Debug only)</span>
<span class="center smaller">Will constantly show a message, can be ignored</span>
<span id="read_error" class="center"></span>

<br>
<span class="center smaller" style="text-decoration: underline;">Video Error</span>
<span id="vid_error" class="center smaller"></span>
</div>
</td>

    </tr></table>
    
    
    </td><td></td></tr>
		 <tr><td><img src='<?php echo $dcrURL;?>webbox/mnset3.gif' border=0 onclick="localqrmnset(3);" style='cursor: hand; cursor: pointer;;'></td><td></td><td><img src='<?php echo $dcrURL;?>webbox/mnset4.gif' border=0 onclick="localqrmnset(4);" style='cursor: hand; cursor: pointer;;'></td></tr>
      </table>
      
</div>


</div>

<script>
function localqrmnset(wh) {
   tmpmn=getobj("qrreader_full");
   if (wh==1) {
      tmpmn.style.top='10px';
      tmpmn.style.left='10px';      
   }
   if (wh==2) {
      tmpmn.style.top='10px';
      tmpmn.style.left=((ujsw-qrujsw)-35)+'px';      
   }
   if (wh==3) {
      tmpmn.style.top=((ujsh-qrujsh)-50)+'px';
      tmpmn.style.left='10px';        
   }
   if (wh==4) {
      tmpmn.style.left=((ujsw-qrujsw)-50)+'px';      
      tmpmn.style.top=((ujsh-qrujsh)-50)+'px';
   }
   setcookie("qrreaderboxpos",wh);
}
tmpqrreaderboxpos=getcookie("qrreaderboxpos");
if (Math.floor(tmpqrreaderboxpos)==0) {
   tmpqrreaderboxpos=1;
}
ulibglobalgetwinsize();
localqrmnset(tmpqrreaderboxpos);
//alert(tmpqrreaderboxpos);
</script>		

<?php
}
?>