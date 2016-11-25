<?php //พ
;
     include("./inc/config.inc.php");
	 html_start();
?><style type="text/css">

/*Default CSS for pan containers*/
.pancontainer{
position:relative; /*keep this intact*/
overflow:hidden; /*keep this intact*/
width:300px;
height:300px;
border:1px solid black;

}

</style>

<script type="text/javascript" src="<?php  echo $dcrURL?>js//jquery/1.4.2/jquery.min.js"></script>

<script type="text/javascript" src="<?php  echo $dcrURL?>js/imagepanner.php">

/***********************************************
* Simple Image Panner and Zoomer- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script><div class="pancontainer" data-orient="center" data-canzoom="yes" style="width:100%; height:100%;">
<img src="<?php  echo $url?>" nostyle="width:700px; height:525px" ID="thisphoto">
</div>

<SCRIPT LANGUAGE="JavaScript">
<!--
	
 var viewportwidth;
 var viewportheight;
 
 // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
 
 if (typeof window.innerWidth != 'undefined')
 {
      viewportwidth = window.innerWidth,
      viewportheight = window.innerHeight
 }
 
// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)

 else if (typeof document.documentElement != 'undefined'
     && typeof document.documentElement.clientWidth !=
     'undefined' && document.documentElement.clientWidth != 0)
 {
       viewportwidth = document.documentElement.clientWidth,
       viewportheight = document.documentElement.clientHeight
 }
 
 // older versions of IE
 
 else
 {
       viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
       viewportheight = document.getElementsByTagName('body')[0].clientHeight
 }
	   tmp=getobj('thisphoto');
	   tmp.style.height=viewportheight
//document.write('<p>Your viewport width is '+viewportwidth+'x'+viewportheight+'</p>');
//-->
</SCRIPT>