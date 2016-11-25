<?php 

$bibratinge=barcodeval_get("bibrating-o-enable");
$bibtage=barcodeval_get("bibtag-o-enable");
//echo "[$bibtage-$bibratinge]";
if ($bibratinge=="yes" || $bibtage =="yes") {
	?><TABLE align=center width="<?php  echo $_TBWIDTH?>" cellpadding=0 cellspacing=0 border=0>
	<TR>
		<TD align=center><table width = "<?php  echo $_TBWIDTH-18?>"  border = "o" cellspacing = "3" cellpadding = "0" bgcolor = "#ffffff" align=center
		style="border: 0px solid white;";
		>
	<TR valign=top>
	<?php  if ($bibratinge=="yes") {?>
		<TD style="border-color: #FFD940;border-style: solid;border-width: 1px;" width=150>
		
		<div width=100% height=20 ID='hiddenbtnrate' style="display:block;text-align:center; cursor: hand; cursor: pointer;;"
onclick="tmp=getobj('bibtagframe'); tmp.style.display='block';tmp=parent.getobj('bibratingframe'); tmp.style.display='block';tmp=getobj('hiddenbtnrate'); tmp.style.display='none';tmp=getobj('hiddenbtntag'); tmp.style.display='none';"
><?php 
	$s=tmq("select * from webpage_bibrating_sum where bibid='$ID' ");
	if (tmq_num_rows($s)==0) {
		$score=0;
	} else {
		$r=tmq_fetch_array($s);
		$score=number_format($r[votescore],1);
	}
	$scoretxt=floor(($score*20)/5);
	$scoretxt=floor($scoretxt*5);

?><img src="<?php  echo $dcrURL; ?>/neoimg/bibrating/l<?php  echo $scoretxt?>.png" width=180 height=20></div>

<iframe width=180 height=150 src="<?php  echo $dcrURL; ?>dublin.bibrating.php?ID=<?php  echo $ID?>&forcedsphiddenbtn=yes" ID="bibratingframe"  FRAMEBORDER="NO" style="display:none" BORDER=0 SCROLLING=NO></iframe></TD>
	<?php  } else {?>
		<TD width=150>&nbsp;</TD>
	<?php  } ?>
	<?php  if ($bibtage=="yes") {?>
		<TD style="border-color: #CECECE;border-style: solid;border-width: 0px;" width=788>
	<div width=100% height=20 ID='hiddenbtntag' style="display:block;text-align: left; cursor: hand; cursor: pointer;;"
onclick="tmp=getobj('bibtagframe'); tmp.style.display='block';tmp=getobj('bibratingframe'); tmp.style.display='block';tmp=getobj('hiddenbtntag'); tmp.style.display='none';tmp=getobj('hiddenbtnrate'); tmp.style.display='none';"
><?php  function local_tagdsp($r) {
		global $_memid;
		echo "<TABLE style=\"display:inline;align=absmiddle\" cellpadding=0 cellspacing=0 border=0>
		<TR valign=middle>
			<TD width=10><img src='./neoimg/bibtag/taghead.png' align=absmiddle border=0 ";
		if ($r[granted]=="yes") {
			echo " style=\"background-color: #C1E0F4; \" ";
		} else {
			echo " style=\"background-color: #EFEFEF; \" ";
		}
		echo "></TD><TD style=\"border-width: 1px; border-style: solid; padding: 0 5 0 5 ;border-left-width: 0px; height: 18px; ";
		if ($r[granted]=="yes") {
			echo "border-color: #336633; background-color: #C1E0F4; ";
		} else {
			echo "border-color: #336633; background-color: #EFEFEF; ";
		}
		echo " ;  \" ><nobr><span class=smaller2
		>";
			//echo "<img src='./neoimg/bibtag/add.png' align=absmiddle border=0 > ";
		echo $r[word1] ;
		if ($r[memid]==$_memid) {
			echo " <img src='./neoimg/bibtag/tag-heart2.png' width=14 height=14 align=absmiddle border=0 alt='Your Tag' hspace=0 vspace=0>";
		}
		echo "</span>";
		echo "</nobr></TD>
		</TR>
		</TABLE>&nbsp;  ";
	}
		$s=tmq("select * from webpage_bibtag where bibid='$ID' ",false);
		if (tmq_num_rows($s)==0) {
			echo "".getlang("รายการนี้ยังไม่มีแท็ก::l::This record not been tagged")."";
		} else {
			echo "<FONT class=smaller>".getlang("แท็กของรายการนี้::l::Tagged").":</FONT> ";
			$s=tmqp("select * from webpage_bibtag where bibid='$ID' order by granted desc","dublin.bibtag.php?ID=$ID","",12);
			while ($r=tmq_fetch_array($s)) {
				local_tagdsp($r);
				echo " ";
				//printr($r);
			}
			
		}
		?></div>
<iframe width=788 height=150 src="<?php  echo $dcrURL; ?>dublin.bibtag.php?ID=<?php  echo $ID?>&forcedsphiddenbtn=yes" ID="bibtagframe"  style="display:none;" FRAMEBORDER="NO" BORDER=0 SCROLLING=NO></iframe></TD>
	<?php  } else {?>
		<TD width=600>&nbsp;</TD>
	<?php  } ?>
	</TR>
	</TABLE></TD>
	</TR>
	</TABLE><?php 
}

if ($_memid!="") {

	if (barcodeval_get("oss-o-isopen") == "yes") {
		 include($dcrs."/member/inc.oss.php");
	};
	if (barcodeval_get("webmenu_memfavbook-o-enable") == "yes") {
		 include($dcrs."/member/inc.memfavbook.php");
	};
	if (barcodeval_get("marcincorrect-o-enable") == "yes") {
		 include($dcrs."/member/inc.reportincorrectmarc.php");
	};

} else {

?><table width = "<?php  echo $_TBWIDTH-20?>" align=center border = "0" cellspacing = "1" cellpadding = "3" bgcolor = "#E6E6E6" >

    <tr bgcolor = #F0F0F0 valign=top>
        <td align=right><?php 
	echo getlang("คุณยังไม่ได้ล็อกอิน คุณสามารถมีกิจกรรมร่วมกับเว็บไซต์ได้ แต่ต้องล็อกอินก่อน::l::You can interact and use many feature after login");
?> ::</td>
<td width=50>
<?php html_xpbtn(getlang("ล็อกอิน::l::Login").",$dcrURL/member/?backto=".urlencode("$dcrURL/dublin.php?ID=$ID").",green");

		?></td>
    </tr>
    <!--
    <tr><td colspan=2 bgcolor = #F0F0F0 valign=top align=right>
    <?php
    /*
$ossname= getlang(barcodeval_get("oss-o-name"));

html_xpbtn($ossname.",javascript:void(null),lightgray,_self::".
getlang("จัดการหนังสือโปรด::l::My Fav. Book").",javascript:void(null),lightgray,_self::".
getlang("แจ้งรายการบรรณานุกรมผิดพลาด::l::Report Incorrect Bib.").",javascript:void(null),lightgray,_self::"
);
*/
    ?>-->
    </td></tr>
</table><?php 	
			
}	
	?>