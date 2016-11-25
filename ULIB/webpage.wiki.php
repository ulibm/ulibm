<?php 
	; 
		
    include ("inc/config.inc.php");
	if (getval("_SETTING","form_at_hp")=="webbox") {
		$tab=tmq("select * from webbox_tab where module='Wiki_Home' ");
		$tab=tfa($tab);
		//echo $addurl2;
		redir($dcrURL."index.php?webboxload=yes&title=$title&deftab=$tab[id]");
		die;
	}
	
	pcache_s("autourl",0,0,false,"wiki");
    include ("./webpage.wiki.inc.php");
	$title=trim($title);
	if ($title=="") {
		$title="wiki:home";
	}
	member_log($_memid,"viewwiki",$title);
	$title=iconvth($title);
	//echo $title;
	//$title= ("คุณรู้หรือไม่");
	$title=stripslashes($title);
	$title=stripslashes($title);
	$title=stripslashes($title);
	$title=addslashes($title);
	$title=str_replace(' ','_',"$title");
	$title=str_replace(' ','_',"$title");
	$title=str_replace(' ','_',"$title");

	$titlestr=stripslashes("$title");
	$titlestr=stripslashes("$titlestr");
	$titlestr=str_replace('_',' ',"$titlestr");
	$titlestr=explode(':',$titlestr);
	$titlekey="WIKI:$title";
	$ismanager=library_gotpermission("webpage-postarticle");
	$iseditpermmanager=library_gotpermission("webeditpagepermission");

	if (count($titlestr)==2) {
		$titlestr=$titlestr[1];
	} else {
		$titlestr=$titlestr[0];
	}

	$html_start_title=urldecode($titlestr);
	
	head();
	$html_start_title=urldecode($titlestr);

	mn_web("webpage");
	stat_add("visithp_type","wiki");

	//$ismanager=loginchk_lib("check");

	$now=time();

	if ($ismanager==true && $realdeleteit=="yes" && $title!="") {
		tmq("delete from webpage_wiki where title='$title' limit 1 ");
	}
	if ($ismanager==true && $deleteit=="yes" && $title!="") {
		?><BR><CENTER><B>Please Confirm Deletion</B><BR> [<?php  echo $title?>]<?php 
		html_xpbtn(getlang("ลบ::l::Delete")."&nbsp;,webpage.wiki.php?title=$title&realdeleteit=yes,red".
"::".getlang("ยกเลิก::l::Cancel")." ,webpage.wiki.php?title=$title,green");
		?></CENTER><BR><?php 
	}
	if ($ismanager==true && $savetopic=="yes" && $title!="") {
		if (editperm_chk($titlekey)!=true) {
			echo getlang("คุณไม่มีสิทธิ์ลบหรือแก้ไขรายการนี้::l::Your login have no permission to modify this article;");
			die;
		}
		$body=addslashes($body);
		$tag=addslashes($tag);
		$wikistatus=','.@join(',',$wikistatus).',';
		$newwikidt=time();
		if ($minichange=="yes") {
			$newwikidt=tmq("select dt from webpage_wiki where title='$title' ",false);
			$newwikidt=tmq_fetch_array($newwikidt);
			$newwikidt=$newwikidt[dt];
		}
		if (floor($newwikidt)==0) {
			$newwikidt=time();
		}
		tmq("update webpage_wiki set body='$body',hasdata='yes',loginid='$useradminid',dt='$newwikidt',tag='$tag',status='$wikistatus' where title='$title' limit 1 ",false);
	}


?>
<TABLE width="<?php  echo $_TBWIDTH?>" align=center cellpadding=0 cellspacing=0 border=0 ID=WEBPAGE_BODY>
<TR valign=top>
	<TD width=200><?php  include("webpage.menu.php");?></TD>
	<TD align=right><A name="topofwikipage"></A>
	
<TABLE width=100% cellpadding=3 cellspacing=0 border=0>
<TR>
	<TD bgcolor=f0f0f0 valign=middle class=smaller>
	<?php //echo getlang("เนื้อหา::l::Content").":";?>
	<TABLE width=200 cellpadding=0 cellspacing=0 border=0 align=right><TR><TD  align=right><?php html_xpbtn(getlang("บทความทั้งหมด/ค้นหา::l::All articles/Search")." ,webpage.wiki.search.php,green");?></TD></TR></TABLE></TD>
</TR>
</TABLE>
		<?php 
$wk=tmq("select * from webpage_wiki where title='$title' and hasdata='yes' ",false);


if (tmq_num_rows($wk)==0) {
	$newmode="yes";
	$authstr=getlang("เนื้อหาใหม่::l::New Topic")."";
} else {
	$newmode="no";
	$wk=tmq_fetch_array($wk);
	$authstr=getlang("โดย::l::By")." " . get_library_name($wk[loginid])." เมื่อ ".ymd_datestr($wk[dt]);
}

?><TABLE width=100% cellpadding=3 cellspacing=0 border=0>
<TR>
	<TD><?php 
/////////////////////////////start name module
$modulecheck=explode(':',$title);
$modulecheck1=$modulecheck[0].':';
$modulecheck2=$modulecheck[1];
//printr($modulecheck);
//เรื่องที่เกี่ยวข้อง (ที่คั่นด้วยคอมม่า) 
//วิกิซใหม่สุด
//วิกิซในหัวข้อ
$modulemodes=Array();
$modulemodes["wiki:"]="wikimodule";
$modulemodes["statuslist:"]="statuslist";
if (count($modulecheck)>0 && $modulemodes[$modulecheck1]!="") {
	if (!file_exists("$dcrs/wikimodule/".$modulemodes["$modulecheck1"]."-name.php")) {

	} else {
		include("$dcrs/wikimodule/".$modulemodes["$modulecheck1"]."-name.php");
	}
} 
////////////////////////////end name module

pagesection($titlestr,"article");
if ($authstr!="") {
	echo "<div style=\"width:100%; display:block; text-align: right;\"><FONT class=smaller2 color=555555>$authstr&nbsp;&nbsp;&nbsp;&nbsp;</FONT></div>";
}

if ($skipwikimodule!="yes" && count($modulecheck)>0 && $modulemodes[$modulecheck1]!="") {
	if (!file_exists("$dcrs/wikimodule/".$modulemodes["$modulecheck1"].".php")) {
		html_dialog("",getlang("WIKI ไม่มีโมดูลนี้::l::This module not exists"));
	} else {
		//echo "execute:".$modulemodes["$modulecheck1"];
		include("$dcrs/wikimodule/".$modulemodes["$modulecheck1"].".php");
		//die;
	}
} else { //////start if wikimodule

if ($newmode=="yes" && $ismanager!=true) {
////////////////////////////////////////////////////////////////////////////////////////////////////////////title not found
	local_wikibox("titlenotfound");
} elseif (($newmode=="yes" || $editit=="yes") && $ismanager==true) {
////////////////////////////////////////////////////////////////////////////////////////////////////////////editing

	if ($editit=="yes") {
		local_wikibox("adm_edit");
		if (editperm_chk($titlekey)!=true) {
			echo getlang("คุณไม่มีสิทธิ์ลบหรือแก้ไขรายการนี้::l::Your login have no permission to modify this article;");
			die;
		}
		?><TABLE width=100%><TR><TD align=right><?php html_xpbtn(getlang("ยกเลิกการแก้ไข::l::Cancel Editing")." ,webpage.wiki.php?title=$title,green");?></TD></TR></TABLE><?php 

	} else {
		local_wikibox("adm_addnew");
	}
		$wk=tmq("select * from webpage_wiki where title='$title' ");
		if (tmq_num_rows($wk)==0) {
			tmq("insert into webpage_wiki set title='$title' ,hasdata='no' ");
			$idadd=tmq_insert_id();
			$wk=tmq("select * from webpage_wiki where id='$idadd' ");
			$wk=tmq_fetch_array($wk);
		} else {
			$wk=tmq_fetch_array($wk);
			$idadd=$wk[id];
		}
?><BR><TABLE width=100% cellpadding=0 cellspacing=0 border=0>
<FORM METHOD=POST ACTION="webpage.wiki.php">
<INPUT TYPE="hidden" NAME="savetopic" value="yes">
<INPUT TYPE="hidden" NAME="title" value="<?php  echo $title?>">
	<TR>
		<TD><?php 
	$html_htmlarea_genwiki="yes";
	form_quickedit("body",stripslashes($wk[body]),"html"); 
	frm_globalupload("wiki-$idadd","body");
?></TD>
</TR>
<?php 
if ($iseditpermmanager==true) {
?><TR>
	<TD align=right><?php 
editperm_form($titlekey);	
?></TD>
</TR><?php 
}?>
<TR>
	<TD align=right> <BR>
	<B><?php  echo getlang("เรื่องที่เกี่ยวข้อง::l::Related Topic");?></B><FONT class=smaller> (<?php  echo getlang("คั่นด้วยเครื่องหมายคอมม่า::l::Seperates with comma");?>)</FONT>: <BR><?php form_quickedit("tag",stripslashes($wk[tag]),"longtext"); 
?></TD>
</TR>
<TR>
	<TD ><BR>
	<B>Status</B>: <BR><?php 
$status=tmq("select * from webpage_wiki_status order by name");
$wikistatused=explode(',',$wk[status]);
while ($statusr=tmq_fetch_array($status)) {
		if ($_ISULIBMASTER=="yes" && $statusr[code]=="logedinonly") {
			$statusr[name]="UUG เท่านั้น::l::UUG Only";
			$statusr[descr]="บทความที่สงวนไว้สำหรับสมาชิก UUG เท่านั้น::l::This article is for UUG Members only";
		}

	?><label style="display:block; height:36; width: 200; float:left; border: 1px solid #aaa; padding:  2 1 1 2; margin: 2 2 2 2 ; background-color: fafafa" class=smaller2><img src="<?php  echo $dcrURL;?>neoimg/wikistatus/<?php  echo $statusr[code]?>.png" align=left><INPUT TYPE="checkbox" NAME="wikistatus[]" value="<?php  echo stripslashes($statusr[code]);?>" style="border-width: 0; padding:0 0 0 0; margin: 0 0 0 0; height: 20" <?php 
	if (in_array($statusr[code],$wikistatused)) {
		echo " checked ";
	}
	?>><BR><?php  echo stripslashes(getlang($statusr[name]));?></label><?php 
}
?></TD>
</TR>
<TR>
	<TD align=right><BR>
<?php 
if ($editit=="yes") {
	?><INPUT TYPE="checkbox" NAME="minichange" value="yes" checked> <?php 
		echo getlang("เป็นการเปลี่ยนแปลงเล็กน้อย::l::Change not much");
}	
?>	
	<INPUT TYPE="submit" value=" Submit "></TD>
</TR>
</FORM>
</TABLE>
		<?php 
} else {
////////////////////////////////////////////////////////////////////////////////////////////////////////////view wiki
	//printr($wk);
	if ($ismanager==true) {
		?><table width = "100%" align=center border = "0" cellspacing = "1" cellpadding = "3" bgcolor = "#bbbbbb" >
		<tr bgcolor = dddddd>
			<td align=right><?php 
		if (editperm_chk($titlekey)==true) {
			html_xpbtn(getlang("ลบ::l::Delete")."&nbsp;,webpage.wiki.php?title=$title&deleteit=yes,red".
			"::".getlang("แก้ไข::l::Edit")." ,webpage.wiki.php?title=$title&editit=yes,green");
		} else {
			echo getlang("คุณไม่มีสิทธิ์ลบหรือแก้ไขรายการนี้::l::Your login have no permission to modify this article;");
		}
		?></td>
		</tr>
		</table><?php 
			editperm_dsp($titlekey);
	}
	$logedinonlychk = strpos("xxxxxx".$wk[status]."xxxxxxx", "logedinonly");

	if ($logedinonlychk !== false && loginchk_lib("check")==false && $_memid=="") {
			echo "<DIV ID='wikiwrapper'>";
			echo "<BR><BR>";
			echo "<TABLE width=450 align=center bgcolor=f5f5f5 cellpadding=5>
			<TR>
				<TD ><B style='color: darkred'>";
			echo "<img border=0 src='./neoimg/Symbols-Warning-48x48.png' style='float:left;'>";
			echo getlang("ขออภัย บทความนี้สำหรับสมาชิกผู้ล็อกอินแล้วเท่านั้น
			::l:: 
			Sorry, this article for logged in members only.
			");
			echo "</B><BR><BR><FONT class=smaller>".getlang("กรุณาล็อกอินด้วยแบบฟอร์มด้านล่าง::l::Please login using login-form below.")."</FONT></TD>
			</TR>
			</TABLE>";
			$backto="$dcrURL/webpage.wiki.php?title=".urlencode(urlencode($title));
			echo "<BR><BR>";
			form_member_login();
			echo "<BR><BR><BR><BR>";
			echo "</DIV>";
	} else {
			$wk[body]=stripslashes($wk[body]);
			$wk[body]=str_replace("\t"," ",$wk[body]);
			$wk[body]=str_replace("	"," ",$wk[body]);
			//$parser2 = &new WikiParser();
			$parser2 = new WikiParser();
			$parser2->reference_wiki = $dcrURL."webpage.wiki.php?title=";
			$output = $parser2->parse($wk[body]);
			$wicipq=tmq("select * from globalupload where keyid='wiki-$wk[id]' and wikiprofile='yes'");
			if (tmq_num_rows($wicipq)>0) {
				?><TABLE width=150 cellpadding=0 cellspacing=0 border=0 style="margin: 5 0 5 5; float:right;">
				<?php 
			while ($wicipqr=tmq_fetch_array($wicipq)) {
				?><TR>
					<TD style="padding: 3 3 3 3; border: black 1px solid; text-align:center" class=smaller2><img src="<?php  echo $dcrURL?>_globalupload/<?php  echo $wicipqr[keyid]?>/<?php  echo $wicipqr[hidename]?>" width=150><BR><?php  echo stripslashes($wicipqr[filename]);?></TD>
				</TR><?php 	
			}
				?>
				</TABLE><?php 
			}
			echo "<DIV ID='wikiwrapper'>";
			//$output=strip_tags($output,"<img><br><a><b><i><li><ul><sup><sub><strike>");
			echo str_webpagereplacer($output);
			echo "</DIV>";

			?><BR><BR><BR><BR><BR><BR><BR><BR><BR><?php 
			$tagged=explode(',',$wk[tag]);
			$tagged=arr_filter_remnull($tagged);
			if (count($tagged)>0) {
				?><TABLE width=95% align=center bgcolor='#0255B0' 
				border=0 cellpadding=3 cellspacing=1>
				<TR>
					<TD bgcolor=F7F7F7 style="padding-left: 20px;"> <B class=smaller><?php  echo getlang("เรื่องที่เกี่ยวข้อง::l::Related Topic");?>: </B><?php 
				while (list($taggedk,$taggedv)=@each($tagged)) {
					?><A HREF="webpage.wiki.php?title=<?php  echo urlencode($taggedv);?>" class=smaller><?php 
						echo getlang($taggedv);
					?></A>, <?php 
				}
			?></TD>
				</TR>
				</TABLE><BR><?php 
		}
	} // end onlylogedin mode
	/////////////////////////
	$linkto=tmq("select *,rand() as randdomid from webpage_wiki where title!='$title' and (body like '%[[$title]]%' or body like '%[[$title|%') order by randdomid",false);
	if (tmq_num_rows($linkto)!=0) {
	?><TABLE width=95% align=center bgcolor='#0255B0' 
	border=0 cellpadding=3 cellspacing=1>
	<TR>
		<TD bgcolor=F7F7F7 style="padding-left: 20px;"> <B class=smaller><?php  echo getlang("เรื่องที่เชื่อมโยงกัน::l::Linked Topic");?>: </B><?php 
	while ($linktor=tmq_fetch_array($linkto)) {
		?><A HREF="webpage.wiki.php?title=<?php  echo urlencode($linktor[title]);?>" class=smaller><?php 
			echo getlang($linktor[title]);
		?></A>, <?php 
	}
?></TD>
	</TR>
	</TABLE><BR><?php 
	}
	//////////////////////////

	$wikistatuesd=explode(',',$wk[status]);
	$wikistatused=arr_filter_remnull($wikistatuesd);
	$statusdb=tmq_dump2("webpage_wiki_status","code","name,descr");
	@reset($wikistatused);
	//printr($wikistatuesd);
	while (list($wikistatusedk,$wikistatusedv)=@each($wikistatused)) {
		//echo "($wikistatusedk,$wikistatusedv)";
		
		if ($_ISULIBMASTER=="yes" && $wikistatusedv=="logedinonly") {
			$statusdb[$wikistatusedv][0]="UUG เท่านั้น::l::UUG Only";
			$statusdb[$wikistatusedv][1]="บทความที่สงวนไว้สำหรับสมาชิก UUG เท่านั้น::l::This article is for UUG Members only";
		}
		?><TABLE width=230  height=60 style="float:left; margin: 4" bgcolor='#530002' 
	border=0 cellpadding=3 cellspacing=1>
	<TR>
		<TD bgcolor=F7F7F7 style="padding-left: 3px;"> <img src="<?php  echo $dcrURL;?>neoimg/wikistatus/<?php  echo $wikistatusedv?>.png" align=left vspace=3> <B class=smaller2><?php 
			echo getlang($statusdb[$wikistatusedv][0])?></B><BR><FONT class=smaller2><?php 
			echo getlang($statusdb[$wikistatusedv][1]);
		?></FONT></TD>
	</TR>
	</TABLE><?php 
	}

	echo str_webpagereplacer(stripslashes(barcodeval_get("webpage-o-htmltoallwikis")));

} ///end view

}//////end if wikimodule
?></TD>
		</TR>
		</TABLE>


</TD>
</TR>
</TABLE>
<?php 
				foot();
				pcache_e();

?>