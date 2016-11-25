<?php  //พ
include("../inc/config.inc.php");
html_start();
$origpid=$pid;
$pid=str_replace("FOOT::","",$pid);
?><style>
body {
	padding: 0px 0px 0px 0px;
	margin: 0px 0px 0px 0px;
	background-color: black!important;
	background-image: none!important;
}
* {
	font-size: 9px!important;
   
   cursor: crosshair!important;
}
</style><?php 
$imgpath=$dcrs."_tmp/_floorplan_$libsiteid.jpg";
$imgurl=$dcrURL."_tmp/_floorplan_$libsiteid.jpg";
if (!file_exists($imgpath)) {
   html_dialog("error","floor plan file not found");
   die;
}
/*
$parent=tmq("select * from printtemplate_sub where code='$pid' ");
$parent=tfa($parent);*/
//printr($parent);
	$currentimagesize = getimagesize($imgpath);
	$image_width = $currentimagesize[0];
	$image_height= $currentimagesize[1];

?>
<script language="JavaScript"><!--
function local_rounder(xx) {
   return Math.floor(xx);
	//xx=Math.floor(xx/5);
	//xx=xx*5;
	//return xx;
}
x=0;
y=0;
w=0;
h=0;
 function local_getvaldown(event) {
   event = event || window.event; // IE-ism
	mousePos = {
		x: event.clientX,
		y: event.clientY
	};
	 tmp=getobj("paperdiv");
     tmp.innerHTML = "Top "+local_rounder(mousePos.y)+" <br>Left:  "+local_rounder(mousePos.x)+"<br>";
	 x=local_rounder(mousePos.x);
	 y=local_rounder(mousePos.y);
	 tmpc=getobj("cropdiv");
	 tmpc.style.display="block";
	 tmpc.style.top=local_rounder(y)+"px";
	 tmpc.style.left=local_rounder(x)+"px";
	 return true;
 }
 function local_getvalmove(event) {
   event = event || window.event; // IE-ism
	mousePos = {
		x2: event.clientX,
		y2: event.clientY
	};
	 tmpc=getobj("cropdiv");
	 tmpc.style.height=(local_rounder(mousePos.y2)-y)+"px";
	 tmpc.style.width=(local_rounder(mousePos.x2)-x)+"px";
	 return true;
}
 function local_getvalup(event) {
   event = event || window.event; // IE-ism
	mousePos = {
		x: event.clientX,
		y: event.clientY
	};
	w=(local_rounder(mousePos.x)-x);
	h=(local_rounder(mousePos.y)-y);
	 tmp=getobj("paperdiv");
     tmp.innerHTML += "Width: "+(local_rounder(mousePos.x)-x)+" ";
     tmp.innerHTML += "Height: "+(local_rounder(mousePos.y)-y)+" ";
	 tmp2=opener.getobj("<?php echo $pjs?>");
	 tmp2.value=local_rounder(x)+";"+local_rounder(y)+";"+local_rounder(w)+";"+local_rounder(h);
	 tmpc=getobj("cropdiv");
	// alert(tmpc.style.height);
	 self.close();
	 return true;
 }
 //-->
 </script>
<div ID="paperdiv" style="position:absolute; background-color: #ffffff; display: block; width: <?php  echo floor($image_width)?>px; height: <?php  echo floor($image_height)?>px;
	background-image: url(<?php echo $imgurl;?>)!important;
	background-repeat: repeat!important;

"
<?php if ($view!="yes") {?>
onmousedown="return local_getvaldown(event)" 
onmousemove="local_getvalmove(event)" 
onmouseup="return local_getvalup(event)"
<?php }?>
></div>

<?php 
$s=tmq("select * from media_place_shelf where pid like'$libsiteid-%'  ",false);
$rida=Array();
while ($r=tfa($s)) {
	$pos=explode(";",$r[mappos2]);
	//printr($pos);
	$rid="div".randid();
	$rida[]=$rid;
	?><a href="javascript:void(null);" ID="<?php  echo $rid?>" 
<?php if ($view=="yes") {?>
onclick="return local_handledrag(event,'<?php  echo $rid;?>','<?php  echo $r[id]?>');";
<?php }?>
style="position:absolute; <?php 
	
	if ($r[id]!=$thisid) {
		echo " background-color: #eeeeee; ";
		if ($r[type1]=="box" ) {
			echo "border: 1px solid black; ";
		} else {
			echo "border: 1px dotted black; ";
		}
	}	else {
		echo " background-color: #eeeeee; ";
		if ($r[type1]=="box" ) {
			echo "border: 1px solid black; ";
		} else {
			echo "border: 2px dotted red; ";
		}
	}
	if ($view!="yes") {
		echo " pointer-events:none;";
	}
	?> display: block; top: <?php  echo $pos[1]?>px; left: <?php  echo $pos[0]?>px; width: <?php  echo $pos[2]?>px; height: <?php  echo $pos[3]?>px; ;  overflow: hidden;
	opacity:0.8; filter:alpha(opacity=80);
"
TITLE="<?php 
echo stripslashes($r[name]);
	?>"
><?php 
echo stripslashes($r[name]);
	?></a>
<?php 
}

?><div ID="cropdiv" style="position:absolute; background-color: #eeeeee;border: 2px dotted black; display: none; width: 1px; height: 1px; pointer-events:none;
"
></div>
<script type="text/javascript">
<!--
managingrid="";
managingID="";
function local_handledrag(event,rid,dbid) {
	managingrid=rid;
	managingID=dbid;
	<?php 
	@reset($rida);
	while (list($k,$v)=each($rida)) {
		?>
   tmp=getobj(<?php echo $v;?>);
   tmp.style.backgroundColor="#eeeeee";
   tmp.style.borderStyle="dotted";
		<?php 
	}
	?>
   event = event || window.event; // IE-ism
   tmp=getobj(rid);
   tmp.style.backgroundColor="#ffcc33";
   tmp.style.borderStyle="solid";
}

var suppressKeypress = false;

function setCmdKey(e) {
	if (managingrid=="") { 
		return;
	}
    e = e || window.event;
    var wrkkeyCode = e.keyCode;
	//alert(wrkkeyCode);
	if (wrkkeyCode==38) { // up
	   tmp=getobj(managingrid);
	   tmpval=tmp.style.top;
	   tmpval=tmpval.replace("px","");
	   tmp.style.top=local_rounder(Math.floor(tmpval)-5)+"px";
	}
	if (wrkkeyCode==40) { // down
	   //alert("here");
	   tmp=getobj(managingrid);
	   tmpval=tmp.style.top;
	   tmpval=tmpval.replace("px","");
	   tmp.style.top=local_rounder(Math.floor(tmpval)+5)+"px";
	  // alert("here"+tmp.style.top);
	}
	if (wrkkeyCode==37) { // left
	   tmp=getobj(managingrid);
	   tmpval=tmp.style.left;
	   tmpval=tmpval.replace("px","");
	   tmp.style.left=local_rounder(Math.floor(tmpval)-5)+"px";
	}
	if (wrkkeyCode==39) { // left
	   tmp=getobj(managingrid);
	   tmpval=tmp.style.left;
	   tmpval=tmpval.replace("px","");
	   tmp.style.left=local_rounder(Math.floor(tmpval)+5)+"px";
	}
	if (wrkkeyCode==100) { // 4 
	   tmp=getobj(managingrid);
	   tmpval=tmp.style.width;
	   tmpval=tmpval.replace("px","");
	   tmp.style.width=local_rounder(Math.floor(tmpval)-5)+"px";
	}
	if (wrkkeyCode==102) { // 6
	   tmp=getobj(managingrid);
	   tmpval=tmp.style.width;
	   tmpval=tmpval.replace("px","");
	   tmp.style.width=local_rounder(Math.floor(tmpval)+5)+"px";
	}
	if (wrkkeyCode==104) { // 8
	   tmp=getobj(managingrid);
	   tmpval=tmp.style.height;
	   tmpval=tmpval.replace("px","");
	   tmp.style.height=local_rounder(Math.floor(tmpval)-5)+"px";
	}
	if (wrkkeyCode==98) { // 2
	   tmp=getobj(managingrid);
	   tmpval=tmp.style.height;
	   tmpval=tmpval.replace("px","");
	   tmp.style.height=local_rounder(Math.floor(tmpval)+5)+"px";
	}
	
	sw=tmp.style.width.replace("px","");
	sh=tmp.style.height.replace("px","");
	sx=tmp.style.left.replace("px","");
	sy=tmp.style.top.replace("px","");
	//saving

	tmp2value=local_rounder(sx)+";"+local_rounder(sy)+";"+local_rounder(sw)+";"+local_rounder(sh);
	tmps=getobj("IFSAVER");
	tmps.src="ifsaver.php?managingID="+managingID+"&data="+tmp2value;
	//alert(tmp2value);
	return false;
}

document.onkeydown = setCmdKey;
document.onkeypress = function() {
    if (suppressKeypress) {
        return false;
    }
};


//-->
</script>
<iframe ID="IFSAVER" name="IFSAVER" style="display:none; backgound-color: white;"></iframe>