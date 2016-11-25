<?php 
	; 
        include ("../inc/config.inc.php");
		if (barcodeval_get("answerpoint_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}
		head();
        mn_web("answerpoint");
		if ($cate=="") {
			$cate="new";
		}
?>
<TABLE cellpadding=0 cellspacing=0 border=0 width="<?php  echo $_TBWIDTH?>" align=center>
<TR valign=top>
	<TD width=200><?php include("menu.php");?></TD>
	<TD><?php 
		$catenamedb["new"]=getlang("คำถามถูกตั้งใหม่::l::New Questtion");
		$catenamedb["wait"]=getlang("คำถามอยู่ระหว่างรอการวิเคราะห์::l::Waiting Question");
		$catenamedb["solved"]=getlang("คำถามที่ตอบแล้ว::l::Solved Question");
		$catenamedb["faq"]=getlang("คำถามพบบ่อย::l::FAQs");
		$catenamedb["tags"]=getlang("แท็ก:::l::Tag:")." ".getlang($tagdb[$tagid]);
		$catenamedb["hide"]=getlang("คำถามที่ถูกซ่อน::l::Hidden Question");

	pagesection($catenamedb[$cate],"article");
$tbname="webpage_answerpoint";


$dsp[2][text]="รายการคำถาม::l::Questions ";
$dsp[2][field]="memid";
$dsp[2][filter]="module:local_display";
$dsp[2][align]="left";


function local_display($wh) {
	global $tagdb;
	global $cate;
	$wh[title]=trim($wh[title]);
	if ($wh[title]=="") {
		$wh[title]="<I>- no title -</I>";
	}
	$s="<A HREF='view.php?id=$wh[id]&cate=$cate'>$wh[title]</A><BR> <FONT class=smaller>&nbsp;&nbsp;".getlang("โดย::l::By");
	if (loginchk_lib("check")==true) {
		$s.=" ".(get_member_name($wh[memid]));
	} else {
		$s.=" ".strip_tags(get_member_name($wh[memid]));
	}
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
	@unlink("./attatch/$fftdeleteid-a1.jpg");
	@unlink("./attatch/$fftdeleteid-a2.jpg");
	@unlink("./attatch/$fftdeleteid-a3.jpg");
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