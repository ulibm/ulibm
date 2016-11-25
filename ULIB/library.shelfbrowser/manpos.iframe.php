<?php  //พ
;
include("../inc/config.inc.php");

html_start();

include("_REQPERM.php");

loginchk_lib();

//////////////////////plan img start
		$tmpshf=tmq("select * from media_place where code='$id' ");
		$tmpshf=tmq_fetch_array($tmpshf);
		$tmpshf=$tmpshf[main];

$spath="$dcrs/_tmp/_floorplan_$tmpshf.jpg";
//echo $spath;
if (file_exists($spath) ) {
	 echo "<img border=0 src='$dcrURL"."_tmp/_floorplan_$tmpshf.jpg'>";
} else {
	die("no floor plan uploaded");
}

		$s2=tmq(" select * from media_place where main='$tmpshf' ");
		while ($r2=tmq_fetch_array($s2)) {
			$s3=tmq(" select * from media_place_shelf where 	pid='$r2[code]' ");
			echo " <!--$r2[code]  -->\n";
			while ($r3=tmq_fetch_array($s3)) {
				$jsid="a".randid();
				echo "    <!-- ---$r3[name]  -->\n";
				$pos=explode(',',$r3[mappos]);
				//printr($r3);
				?><div style="display: block; width: 100; height: 16; position:absolute; left:<?php  echo $pos[0]?>; top:<?php  echo $pos[1]-16?>; z-index: 0; "  style="cursor:move; border: 0 red solid; padding: 0 0 0 0;" ID="root<?php  echo $jsid;?>">
				<TABLE cellpadding=0 cellspacing=0 border=0 width=100>
				<TR valign=top>
					<TD align=left width=16><div ID="handle<?php  echo $jsid;?>" style="padding: 0 0 0 0; margin: 0 0 0 0;"><A HREF="javascript:void(null)" 
					onmouseover="tmp=getobj('<?php echo $jsid?>');tmp.style.display='block';"
					onmouseout="tmp=getobj('<?php echo $jsid?>');tmp.style.display='none';"><img src='../neoimg/pin16.png' align=absmiddle style="float:left;" border=0 hspace=0 vspace=0></A></div></TD>
					<TD width=84> <div ID="<?php  echo $jsid;?>"
				style="display:none; width: 170; noheight: 38;background-image: url(../neoimg/alpha30.png); padding: 3 3 3 3;">
				<?php echo getlang($r2[name]);?><BR>
				<B class=smaller >&nbsp;<?php  echo getlang($r3[name]);?></B></div></TD>
				</TR>
				</TABLE>
				</div>
				
</DIV>

<script type="text/javascript">
var theHandle<?php  echo $jsid;?> = document.getElementById("handle<?php  echo $jsid;?>");
var theRoot<?php  echo $jsid;?> = document.getElementById("root<?php  echo $jsid;?>");
Drag.init(theHandle<?php  echo $jsid;?>, theRoot<?php  echo $jsid;?>);
theRoot<?php  echo $jsid;?>.onDragEnd = function(x, y) {// x, y contains current offset coords of drag
x=Math.round(x / 5) *5;
y=Math.round(y / 5) *5;
ysave=y+16
this.style.top=y
this.style.left=x
getobj("POSSAVER").src="savepos.php?subid=<?php  echo $r3[id]?>&js_x="+x+"&js_y="+ysave;
}
</script>
<?php 
			}
		}
		?><iframe width=100 src="" height=100 ID='POSSAVER' frameborder=no style="display:none;"></iframe><?php 
die;
?>