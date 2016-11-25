<?php
include("../../inc/config.inc.php");
?>    <script src="<?php echo $dcrURL?>_misc/qrcodereader/jquery-1.9.1.min.js"></script>
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
   			document.body.style.background = "#ff0000";
            setTimeout("localrestorebg();",400);
         } else {
            document.body.style.background = "#000000";
            setTimeout("localrestorebg();",400);
            setTimeout("localrestorebc();",3000);
            top.tmp=top.getobj("main");
            top.tmp.src="main.checkout.php?memberbarcode="+data;
         }
         $('#read').html(data);
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
    </script>
    <style>
    body {
    margin: 0px 0px 0px 0px;
    }
    </style>
    <table width=100% border=0> <tr valign=top>
    
    <td width=250 bgcolor=#000000><div  class="center" id="reader" style="width:300px;height:250px;"></div></td>
    
    <td>
    <span class="center"><b>Result</b></span>
<span id="read" class="center" style="font-size:20px;">-</span>
<br>
<div style="display:block; color: #cccccc">
<span class="center">Read Error (Debug only)</span>
<span class="center">Will constantly show a message, can be ignored</span>
<span id="read_error" class="center"></span>

<br>
<span class="center">Video Error</span>
<span id="vid_error" class="center"></span>
</div>
</td>

    </tr></table>
    
