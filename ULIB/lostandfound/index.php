<?php 
	; 
        include ("../inc/config.inc.php");
		if (barcodeval_get("lostandfound_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}
		head();
        mn_web("lostandfound");
		if ($cate=="") {
			$cate="new";
		}

?>
<TABLE cellpadding=0 cellspacing=0 border=0 width="<?php  echo $_TBWIDTH?>" align=center>
<TR valign=top>
	<TD width=200><?php include("menu.php");?></TD>
	<TD><?php 
		$catenamedb["new"]=getlang("รายการของหาย::l::Lost and found items");
		$catenamedb["destroy"]=getlang("รายการที่ทำลายทิ้งแล้ว::l::Abandoned items");
		$catenamedb["solved"]=getlang("มีผู้มารับแล้ว::l::Picked up items");
		$catenamedb["hide"]=getlang("รายการที่ถูกซ่อนไว้::l::Hidden Items");
		$catenamedb["tags"]=getlang("แท็ก:::l::Tag:")." ".getlang($tagdb[$tagid]);
	pagesection($catenamedb[$cate],"article");
$tbname="webpage_lostandfound";


$dsp[2][text]="รายการสิ่งของที่หาย::l::Lost and found items";
$dsp[2][field]="memid";
$dsp[2][filter]="module:local_display";
$dsp[2][align]="left";

function local_display($wh) {
	global $cate;
	global $tagdb;
	$wh[title]=trim($wh[title]);
	if ($wh[title]=="") {
		$wh[title]="<I>- no title -</I>";
	}
	$s="<A HREF='view.php?id=$wh[id]&cate=$cate'>$wh[title]</A><BR> <FONT class=smaller>&nbsp;&nbsp;".getlang("โดย::l::By");
		$s.=" ".(html_library_name($wh[memid]));
	$s.="</FONT><FONT class=smaller2><BR>&nbsp;&nbsp;".getlang("เมื่อ::l::since");
	$s.=" ".ymd_datestr($wh[dt]) . " (" .ymd_ago($wh[dt]).")";
	$taglist=explode(',',$wh[taglist]);
	$tags="";
	while (list($k,$v)=each($taglist)) {
		if ($v!="") {
			$tags.=", ".$tagdb[$v];
		}
	}
	$tags=trim($tags,',');
	if ($tags!="") {
		$tags="<BR>&nbsp;&nbsp;".getlang("แท็ก::l::Tags").":$tags";
	}
	$s.= " $tags</FONT>";
	return $s;
}


$o[tablewidth]="100%";

if ($fftmode=="delete") {
	@unlink("./attatch/$fftdeleteid-1.jpg");
	@unlink("./attatch/$fftdeleteid-2.jpg");
}
if ($cate!="tags") {
	$limit=" cate='$cate' ";
} else {
	$limit=" taglist like '%,$tagid,%' ";
}
$c=Array();

fixform_tablelister($tbname,$limit,$dsp,"no","no","yes","cate=$cate",$c," dt desc ",$o);

	?></TD>
</TR>
</TABLE>
<?php 
				foot();
?>