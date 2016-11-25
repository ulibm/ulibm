<?php 
    ;
	include ("../inc/config.inc.php");

if ($_ISULIBMASTER=="yes") {
	head();
	mn_web("webpage");
	pagesection(getlang("รายละเอียด::l::Details"));
	$s=tmq("select * from ulib_clientlogins where loginid='".substr($id,4)."' ");
	$s=tmq_fetch_array($s);
	?><table align=center width="<?php echo $_TBWIDTH?>">
	<tr valign=top>
		<td class=table_head width=200><?php  echo getlang("ชื่อหน่วยงาน::l::Organization name");?></td>
		<td class=table_td><?php  echo $s[name]?></td>
	</tr>
	<tr valign=top>
		<td class=table_head width=200><?php  echo getlang("อีเมล์::l::Email");?></td>
		<td class=table_td><?php  echo $s[email]?></td>
	</tr>
	<tr valign=top>
		<td class=table_head width=200><?php  echo getlang("เบอร์โทรศัพท์::l::Tel.");?></td>
		<td class=table_td><?php  echo $s[tel]?></td>
	</tr>
	<tr valign=top>
		<td class=table_head width=200><?php  echo getlang("ที่อยู่::l::Address");?></td>
		<td class=table_td><?php  echo $s[address]?></td>
	</tr>
	<tr valign=top>
		<td class=table_head width=200><?php  echo getlang("ประวัติ M/A/Support::l::M/A,Support log");?></td>
		<td class=table_td><?php 
	$s="Support ";	
	$c1=tmq("select * from ulib_clientlogins_support where uug='".substr($id,4)."' ");
	$c1=tmq_num_rows($c1);

	$c2=tmq("select * from ulib_clientlogins_ma where uug='".substr($id,4)."' ");
	$c2=tmq_num_rows($c2);
	$s.=" $c1 ครั้ง ";

	$s1=tmq("select * from ulib_clientlogins_ma where uug='".substr($id,4)."' and matype='เริ่มM-A' ");
	if (tmq_num_rows($s1)==0) {
		$s.=" : ยังไม่เคย M/A";
	} else {
		$s1=tmq_fetch_array($s1);
		$dts=$s1[dt];
		$s1=tmq("select * from ulib_clientlogins_ma where uug='".substr($id,4)."' and matype<>'เริ่มM-A' ");
		//echo "<br>$dts";
		while ($r=tmq_fetch_array($s1)) {
			$dts=$dts+floor(60*60*24*30*floor($r[month]));
			//echo "<br>".floor(60*60*24*30*floor($r[month]));
		}
		//echo "<br>$dts";
		$s.=" :: M/A $c2 ครั้ง  คุ้มครองถึง ".ymd_datestr($dts,"date");;
	}
	$s.=" <!-- = $p1 ฿ -->";
	echo $s;
	?></td>
	</tr>
	</table><br><br><?php 
			pagesection(getlang("ชื่อผู้ที่สามารถติดต่อได้สะดวก"));

$tbname="ulib_clientlogins_contact";

//dsp

$dsp[3][text]="รายชื่อผู้ติดต่อ";
$dsp[3][field]="id";
$dsp[3][filter]="module:local_dsp3";
$dsp[3][width]="70%";
function local_dsp3($wh) {
	$s=($wh[name])." <font class=smaller2>" .($wh[email])." ".$wh[tel]."</font> (รับผิดชอบด้าน: $wh[role])
	";
	 return $s;
}

fixform_tablelister($tbname," uug='".substr($_memid,4)."' ",$dsp,"no","no","no","id=$id",$c,"name");
?>
<center><a href="uug.staff.php" class=a_btn>คลิกที่นี่เพื่อแก้ไข</a>
</center><?php 
			pagesection(getlang("Support"));

$tbname="ulib_clientlogins_support";

$dsp[3][text]="ประวัติ support";
$dsp[3][field]="id";
$dsp[3][filter]="module:local_dsp";
$dsp[3][width]="70%";
function local_dsp($wh) {
	$s=ymd_datestr($wh[dt])." <font class=smaller2>" .ymd_ago($wh[dt])."</font><br>
$wh[descr]
	";
	 return $s;
}

$dsp[5][text]="ค่าใช้จ่าย";
$dsp[5][field]="price";
$dsp[5][width]="10%";
fixform_tablelister($tbname," uug='".substr($id,4)."' ",$dsp,"no","no","no","id=$id",$c,"dt desc");

			pagesection(getlang("M/A"));

$tbname="ulib_clientlogins_ma";

$dsp[3][text]="ประวัติ support";
$dsp[3][field]="id";
$dsp[3][filter]="module:local_dsp2";
$dsp[3][width]="70%";
function local_dsp2($wh) {
	$s=ymd_datestr($wh[dt],"date")." ($wh[matype]) <font class=smaller2>" .ymd_ago($wh[dt])."</font><br>
$wh[descr]
	";
	 return $s;
}

$dsp[4][text]="จำนวน";
$dsp[4][field]="price";
$dsp[4][width]="10%";

$dsp[5][text]="เวลา (เดือน)";
$dsp[5][field]="month";
$dsp[5][width]="10%";
fixform_tablelister($tbname," uug='".substr($id,4)."' ",$dsp,"yes","yes","yes","id=$id",$c,"dt desc");
	foot();
	die;
}









$chk=tmq("select * from member where UserAdminID='$id' and (publishbookinfo='yes' or UserAdminID='$_memid');");
if (tmq_num_rows($chk)==0 && loginchk_lib("check")==false) {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("<?php  echo getlang("ขออภัย ไม่พบสมาชิกที่ต้องการ หรือ สมาชิกไม่ต้องการเผยแพร่ข้อมูลส่วนตัว\\n กรุณาคลิก OK เพื่อกลับหน้าหลัก::l::Sorry, member not found or member don't want to publish his/her information \\n click OK to return to homepage");?>");
		top.location="<?php  echo $dcrURL?>";
	//-->
	</SCRIPT><?php 
	die;
}
	head();
	mn_web("webpage");


?><img src="<?php  echo $dcrURL?>neoimg/spacer.gif" width=700 height=10><BR><TABLE width="<?php  echo $_TBWIDTH?>" align=center border=0 cellpadding=0 cellspacing=0>
<TR valign=top>
	<TD width=150 align=center><?php 
	echo html_membericon($id);
	?></TD>
	<TD style="padding-left:10"><?php 
	
 //tab display
 $tmp=Array();
$tmp[favbook]="1";
$tmp[comment]="2";
$tmp[tagged]="3";
$tmp[rating]="4";

	if ($mode=="") {
		$mode="favbook";
	}
	
	if ($mode=="favbook") {
		$s=tmq("select * from webpage_memfavbook where memid='$id' order by rand(); ");
	}
	if ($mode=="comment") {
		$s=tmq("select distinct bibid from webpage_bookcomment where memid='$id' order by rand(); ");
	}
	if ($mode=="tagged") {
		$s=tmq("select * from webpage_bibtag where memid='$id' order by bibid, rand(); ");
	}
	if ($mode=="rating") {
		$s=tmq("select * from  webpage_bibrating_log where memid='$id' order by rand(); ");
	}

		$c1=tmq_num_rows(tmq("select id from webpage_memfavbook where memid='$id' "));
		$c2=tmq_num_rows(tmq("select id from webpage_bookcomment where memid='$id'  "));
		$c3=tmq_num_rows(tmq("select id from webpage_bibtag where memid='$id'  "));
		$c4=tmq_num_rows(tmq("select id from  webpage_bibrating_log where memid='$id' "));


$tabstr=$tmp[$mode]."::g::".getlang("หนังสือเล่มโปรด::l::Favourite")." ($c1),viewmember.php?id=$id&mode=favbook,,,$dcrURL"."neoimg/gicons/action/ic_favorite_white_24dp.png";

$tabstr.="::".getlang("แสดงความเห็น::l::Commented")." ($c2),viewmember.php?id=$id&mode=comment,,,$dcrURL"."neoimg/gicons/communication/ic_comment_white_24dp.png";
$tabstr.="::".getlang("ให้แท็ก::l::Tagged")." ($c3),viewmember.php?id=$id&mode=tagged,,,$dcrURL"."neoimg/gicons/action/ic_loyalty_white_24dp.png";
$tabstr.="::".getlang("ให้คะแนน::l::Give Rating")." ($c4),viewmember.php?id=$id&mode=rating,,,$dcrURL"."neoimg/gicons/action/ic_stars_white_24dp.png";
$_TBWIDTHprev=$_TBWIDTH;
$_TBWIDTH="100%";
if (barcodeval_get("webpage-o-mem_menustyle")=="Classic") {
   html_xptab($tabstr);
} else {
   html_flattab($tabstr);
}
$_TBWIDTH=$_TBWIDTHprev;

	$moddb[favbook]="หนังสือในรายการโปรด::l::My Favourite books";
	$moddb[comment]="แสดงความเห็น::l::Commented";
	$moddb[tagged]="ให้แท็ก::l::Tagged";
	$moddb[rating]="ให้คะแนน::l::Give Rating";

	if ($mode=="favbook") {
		$s=tmq("select * from webpage_memfavbook where memid='$id' order by rand(); ");
	}
	if ($mode=="comment") {
		$s=tmq("select distinct bibid from webpage_bookcomment where memid='$id' order by rand(); ");
	}
	if ($mode=="tagged") {
		$s=tmq("select * from webpage_bibtag where memid='$id' order by bibid, rand(); ");
	}
	if ($mode=="rating") {
		$s=tmq("select * from  webpage_bibrating_log where memid='$id' order by rand(); ");
	}


?><TABLE border=0 cellpadding=0 cellspacing=0 width="100%">
<TR><TD height=20 background="<?php  echo "$dcrURL"."neoimg/bookcase/header.jpg";?>" colspan=5
align=right><FONT class=smaller COLOR="#695B3D"><?php  echo getlang($moddb[$mode]);?>&nbsp; &nbsp;</FONT></TD></TR>
<?php  
$i=0;
$perrow=5;
if (tmq_num_rows($s)==0) {
echo "<TR style='background-image:url($dcrURL"."neoimg/bookcase/background.jpg);' valign=top>
	<TD width=10 background='$dcrURL"."neoimg/bookcase/lists.jpg'></TD>
	<TD width=2><img src='$dcrURL"."neoimg/bookcase/mask_left.png'></TD>
	<TD style='height: 240px; padding-bottom: 20' valign=middle align=center> no items
	";

}
while ($r=tmq_fetch_array($s)) {
	$tagclosed=false;
	if ($i % $perrow==0) {
		echo "<TR style='background-image:url($dcrURL"."neoimg/bookcase/background.jpg);' valign=top>
		<TD width=10 background='$dcrURL"."neoimg/bookcase/lists.jpg'></TD>
		<TD width=2><img src='$dcrURL"."neoimg/bookcase/mask_left.png'></TD>
		<TD style='height: 240px; padding-bottom: ";
		if ($mode=="tagged" || $mode=="rating") {
			echo 2;
		} else {
			echo 20;
		}
		echo "' valign=bottom>
		";
	}
	$text="";
	if ($mode=="tagged") {
		//printr($r);
		$text=" <FONT class=smaller2 color=#37407B><BR>$r[word1]</FONT>";
	}
	if ($mode=="rating") {
		//printr($r);
		$text=" <FONT class=smaller2 color=#37407B><BR> Rating: $r[score]</FONT>";
	}
	echo res_icon($r[bibid]," style='display:inline; margin: 0 0 0 0; ' ",$text);
	//echo $i." ".marc_gettitle($r[bibid])."<BR>";
?>

<?php 
	$i++;
	if ($i % $perrow==0) {
		echo "</TD>
		<TD width=2><img src='$dcrURL"."neoimg/bookcase/mask_right.png'></TD>
		<TD width=10 background='$dcrURL"."neoimg/bookcase/lists.jpg'></TD>
		</TR>";
		$tagclosed=true;
	}
}	
if ($tagclosed==false) {
	echo "</TD>
		<TD width=2><img src='$dcrURL"."neoimg/bookcase/mask_right.png'></TD>
		<TD width=10 background='$dcrURL"."neoimg/bookcase/lists.jpg'></TD>
		</TR>";
}

?>
</TABLE>
<br /><a href="../getfeed.php?feed=membermatfeed&memid=<?php  echo $id ; ?>&mode=<?php  echo $mode ?>" class=feedbtn target=_blank><img align=absmiddle src="../neoimg/feed-icon-14x14.png" border=0> <?php  echo getlang("Feed");?></a>
<?php 

	?></TD>
</TR>
</TABLE><?php 





	foot();
?>