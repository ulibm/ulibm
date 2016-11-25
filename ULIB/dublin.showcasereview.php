<?php 
if ($ID!="") {
	$webreview=tmq("select * from webpage_showcase where mid='$ID' ");
	if (tmq_num_rows($webreview)!=0) {
		$webreview=tmq_fetch_array($webreview);
?><TABLE width=780 align=center cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD align=right>
	<TABLE width=600 align=right cellpadding=0 cellspacing=0 border=0>
	<TR>
		<TD background="./neoimg/writereview_t.gif" style="padding-top: 50px; padding-left: 50px; "><FONT style="border-color: 999999; border-style: dotted; border-width: 0; border-bottom-width: 3 ; font-size: 20px; font-weight: bold; display: block; width: 90%"><?php  echo stripslashes($webreview[title]);?></FONT>
		<FONT style='color: 666666; font-size: 13'><?php 
	echo getlang("Review โดย::l::Review by");	
	echo " ";
	echo html_library_name($webreview[loginid]);
	echo " " . getlang("เมื่อ::l::");;
	echo ymd_datestr($webreview[dt],'date');
?></FONT></TD>
	</TR>
	<TR>
		<TD background="./neoimg/writereview_m.gif" style="padding-top: 2px; padding-left: 50px; padding-right: 50px; padding-top: 10px;"><?php  echo stripslashes($webreview[text]);?></TD>
	</TR>
	<TR>
		<TD><img src="./neoimg/writereview_b.gif" hspace=0 vspace=0></TD>
	</TR>
	</TABLE>

	</TD>
</TR>
</TABLE>
<BR>
<?php 
	}
	if (loginchk_lib('check')==true ) { 
		$issuggestbook=library_gotpermission("webpace-suggestbook");
		$isdbfulltext=library_gotpermission("dbfulltext-manage");
	?><table width = "<?php  echo $_TBWIDTH?>" align=center border = "0" cellspacing = "1" cellpadding = "3" bgcolor = "#bbbbbb" >
    <tr bgcolor = dddddd>
				<td align=right>
				<?php 
		$html_xpbtnstrlib="";
if( $issuggestbook=="yes") {
	///start showcase - โค้ดด้านล่าง โยงกับ library.webmenu/h_showcase.php
	if ($setshowcase=="up") {
		tmq("update media set webpageshowcase='yes' where ID='$ID' ");
		$c=tmq("select * from index_db where mid='$ID' ");
		if (tmq_num_rows($c)==0) {
			 index_reindex($ID);
		} else {
			 tmq("update index_db set webpageshowcase='yes' where mid='$ID' ");
		}
	}
	if ($setshowcase=="down") {
	 tmq("update media set webpageshowcase='' where ID='$ID' ");
	 tmq("update index_db set webpageshowcase='' where mid='$ID' ");
	}
	//end showcase
	$html_xpbtnstrlib.=getlang("บรรณารักษ์แก้ไข Review::l::Librarian edit Review").",$dcrURL/library.webmenu/h_showcase.review.php?ID=$ID&backtome=indexbib,green::";
	 $r=tmq("select * from media where ID='$ID' and webpageshowcase='yes' ");
	  $n=tmq_num_rows($r);
	  if ($n==0) {
		  $html_xpbtnstrlib.=getlang("นำขึ้น Showcase::l::Send to Showcase").",$dcrURL/dublin.php?setshowcase=up&ID=$ID,green::" ;
	  } else {
		  $html_xpbtnstrlib.=getlang("นำออกจาก Showcase::l::Remove from Showcase").",$dcrURL/dublin.php?setshowcase=down&ID=$ID,green::" ;
	  }
}
if( $isdbfulltext=="yes") {
 $r=tmq("select * from media_ftitems where mid='$ID' and fttype='cover' ");
  $n=tmq_num_rows($r);
	$n="(".number_format($n).")";
  $html_xpbtnstrlib.=getlang("ภาพปก $n::l::Cover $n").",$dcrURL/library.dbfulltext/mediacontent.php?FTCODE=cover&mid=$ID,green::" ;
}
if (library_gotpermission("DBbook")) {
	$html_xpbtnstrlib.=getlang("แก้ไขบรรณานุกรม::l::Edit Bib.").",$dcrURL"."library.book/addDBbook.php?IDEDIT=$ID,green::"	;
}
$html_xpbtnstrlib.=getlang("ประวัติการแก้ไข::l::Edit log.").",$dcrURL/dublin.editlog.php?ID=$ID,blue::"	;
$html_xpbtnstrlib.=getlang("ประวัติการยืม::l::Checkout log.").",$dcrURL/dublin.checkoutlog.php?ID=$ID,blue"	;
html_xpbtn($html_xpbtnstrlib);
		?></td>
    </tr>
</table><?php 
}
}

?>