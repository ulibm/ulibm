<?php  //พ
function html_flattab($str,$isecho=true) {
	//frm= text,url,color [,_target]
	global $html_flattab_called;
	global $dcrURL;
	global $html_flattab_i;
	global $_TBWIDTH;
	$html_flattab_i=floor($html_flattab_i)+1;
	$cols=explode(",",barcodeval_get("webpage-o-flattabcol"));
	//printr($cols);
	if ($html_flattab_called!="yes") {
	  $html_flattab_called="yes";
	  ?>
	  <!--<link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">-->

<style>


.flattabdiv:hover {
-webkit-transform: rotateY(180deg); /* flip horizontally 180deg*/
-moz-transform: rotateY(180deg);
transform: rotateY(180deg);
background: #c1e4ec; /* bgcolor of button onMouseover*/
-webkit-transition-delay: 0s;
-moz-transition-delay: 0s;
transition-delay: 0s;
}
.flattabdiv {
-webkit-transition:all 300ms ease-out; /* CSS3 transition. Last value is pause before transition play */
-moz-transition:all 300ms ease-out;
transition:all 300ms ease-out;
text-align: center;
margin-top: 5px;
margin-right: 5px;
}

</style>


	  <?php
	}
	$boxwidth=100;
	$boxheight=80;
	$str=explode("::",$str);
	$result="";
	//find box num s
	$runi=0;
//printr($str);
   @reset($str);
	while (list($k,$v)=each($str)) {
		$i=explode(',',$v);
		//printr($i);
		if (@count($i)<2) continue;
		if ($i[0]=="") {
		 continue;
		}
		$runi++;
   }
   //find box num e
	$result.='<table border=0 cellspacing=0 cellpadding=0 align=center width="'.(($boxwidth+6)*$runi).'"><tr><td>';
/*

<li><a href="http://www.dynamicdrive.com" title="Search"><span class="icon-search"></span></a> <b>Search</b></li>
<li><a href="http://www.dynamicdrive.com"><span class="icon-gears"></span></a> <b>Gears</b></li>
<li><a href="http://www.dynamicdrive.com"><span class="icon-rss"></span></a> <b>RSS</b></li>
<li><a href="http://www.dynamicdrive.com"><span class="icon-twitter"></span></a> <b>Twitter</b></li>
<li><a href="http://www.dynamicdrive.com"><span class="icon-rocket"></span></a> <b>Rocket</b></li>


<br /><br />

<ul class="flatflipbuttons second">
<li><a href="http://www.dynamicdrive.com"><span><img src="http://www.dynamicdrive.com/cssexamples/media/rss-heart.png" /></span></a></li>
<li><a href="http://www.dynamicdrive.com"><span><img src="http://www.dynamicdrive.com/cssexamples/media/twitter-heart.png" /></span></a></li>
<li><a href="http://www.dynamicdrive.com"><span><img src="http://www.dynamicdrive.com/cssexamples/media/facebook-heart.png" /></span></a></li>
<li><a href="http://www.dynamicdrive.com"><span><img src="http://www.dynamicdrive.com/cssexamples/media/google-heart.png" /></span></a></li>
<li><a href="http://www.dynamicdrive.com"><span><img src="http://www.dynamicdrive.com/cssexamples/media/stumble-heart.png" /></span></a></li>
</ul>

*/

$defid =$str[0];
$runi=0;
//printr($str);
@reset($str);
	while (list($k,$v)=each($str)) {
		$i=explode(',',$v);
		//printr($i);
		if (@count($i)<2) continue;
		if ($i[0]=="") {
		 continue;
		}
      //echo $runi.count($cols)." ";;
   	$runi++;
   	if ($runi>=count($cols)) {
   	  $runi=1;
   	}


		if ($i[3]=="") {
			$i[3]="_self";
		}
		$result.='';
		$result.='<div style="display:block; width: '.$boxwidth.'px; height: '.$boxheight.'px; float:left; background-color: #'.$cols[$runi].'; text-vertical-align: middle; ';
		if ($runi==$defid) {
         $result.=' -webkit-box-shadow: 0px 0px 10px 0px #'.$cols[$runi].';
         -moz-box-shadow:    0px 0px 10px 0px #'.$cols[$runi].';
         box-shadow:         0px 0px 10px 0px #'.$cols[$runi].'; ';
		}
		$result.='" class="flattabdiv">
<a href="'.$i[1].'" target="'.$i[3].'" style=" display: table; width: 100%; height: 100%"
onmouseover="tmpflt=getobj(\'flattabdescr'.$html_flattab_i.'\'); tmpflt.innerHTML=\''.addslashes(getlang($i[0])).'\';">
   <span style="vertical-align:middle;    display: table-cell;">
      <img src="'.$i[4].'" style="min-width: 20px;min-height: 20px;"/>
   </span>
</a>
		</div> ';
		//$result.='<li><a href="'.$i[1].'" target="'.$i[3].'"><span><img src="'.$i[2].'" style="min-width: 20px;min-height: 20px;"/></span></a>'.getlang($i[0]).'';
	}
	$result.='
	</td></tr>
	
	<tr><td align=center><div ID="flattabdescr'.$html_flattab_i.'" style="font-weight: bold; font-size: 20px; color: #777777; height: 22px;"></div></td></tr>
	</table>';
	if ($isecho==true) {
		echo $result;
	} else {
		return $result;
	}
}
?>