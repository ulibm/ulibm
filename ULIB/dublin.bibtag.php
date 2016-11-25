<?php  
	include ("./inc/config.inc.php");
	$now=time();
	$s=tmq("select * from media where ID='$ID' ");
	if (tmq_num_rows($s)==0) {
		die("bib $ID not found");
	}

	html_start();

	function local_tagdsp($r) {
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
?>
<TABLE cellpadding=0 cellspacing=0 border=0 bgcolor="#F2F8FF" width=100% height=100%>
<TR>
	<TD style="padding-top: 5px; padding-left: 10px;
	background-image: url(./neoimg/tagging-icon.png); background-repeat: no-repeat; background-position: 490 5; "
	><?php  
	$tagname=trim($tagname);
	$tagname=stripslashes($tagname);
	$tagname=stripslashes($tagname);
	$tagname=stripslashes($tagname);
	$tagname=stripslashes($tagname);
	$tagname=addslashes($tagname);
	if ($savetag=="yes" && $tagname!='' && $_memid!='') {
		$chk=tmq("select * from webpage_bibtag where bibid='$ID' and word1='$tagname' ");
		if (tmq_num_rows($chk)!=0) {
			echo "<FONT class=smaller2 color=red>[$tagname] already exists<BR></FONT>";
		} else {
			$autogrant=barcodeval_get("bibtag-o-autogrant");
			if (loginchk_lib("check") == true) {
				$autogrant="yes";
			}
			tmq("insert into webpage_bibtag set 
			bibid='$ID' ,
			word1='$tagname' ,
			memid='$_memid' ,
			dt='$now' ,
			granted='$autogrant' ,
			libid='$useradminid' 
			");
			if ($autogrant=="yes" || loginchk_lib("check") == true) {
				index_reindex($ID);
			}
		}
	}
	if ($addtagform=="yes") {
		?><TABLE cellpadding=0 cellspacing=0 border=0  width=100% height=100%>
<FORM METHOD=POST ACTION="dublin.bibtag.php">
<INPUT TYPE="hidden" NAME="savetag" value="yes">
<INPUT TYPE="hidden" NAME="ID" value="<?php echo $ID?>">
					<TR>
			<TD valign=top>
<INPUT TYPE="text" NAME="tagname" ID="INTERNALTEXTBOXKWSEARCH"
	onkeyup="internaltextboxsuggestion(this)" AUTOCOMPLETE=OFF maxlength=100 size=50
> <INPUT TYPE="submit" value="<?php echo getlang("เพิ่มแท็ก::l::Add tag");?>"> <A HREF="dublin.bibtag.php?ID=<?php echo $ID;?>" class=smaller style="color:darkred"><?php echo getlang("ยกเลิก::l::Cancel");?></A>
<?php  
		include("$dcrs/webpage.inc.quicksearch.globalinc.php");
?>
			</TD>
		</TR>
		</FORM>
		</TABLE>
<?php  
			?><SCRIPT LANGUAGE="JavaScript">
		<!--
	getobj('INTERNALTEXTBOXKWSEARCH').focus();
			quicksearchmode="addbibtag";
			quicksearchlen="5";
			quicksearchaddword="yes";
			quicksearchaddtaglist="no";
		//-->
		</SCRIPT><?php  
} else {

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
		echo "<BR>";
		if ($_memid=="") {
			echo "<A HREF='$dcrURL/member/index.php?backto=".urlencode("$dcrURL/dublin.php?ID=$ID")."' target=_top><FONT class=smaller2>".getlang("กรุณาล็อกอินก่อนให้แท็ก::l::Please login before create tag for this record.")."</FONT></A>";
		} else {
			echo "<A HREF='dublin.bibtag.php?ID=$ID&addtagform=yes' class=a_btn><FONT class=smaller2 ><img src='./neoimg/bibtag/add.png' align=absmiddle border=0> ".getlang("คลิกที่นี่เพื่อให้แท็ก::l::Click here to create tag")."</FONT></A>";
		}
		echo "<BR><FONT class=smaller2>";
		echo getlang("แท็กเป็นเสมือนคำสำคัญที่ติดไปกับรายการวัสดุสารสนเทศ ซึ่งคำเหล่านี้จะเป็นคำง่าย ๆ ที่ใช้กันทั่วไป <BR>ทำให้การสืบค้นได้ผลตรงกับความต้องการของผู้ใช้มากขึ้น::l::Tag is like a keyword or category label to identify group of subject area of each book with a simple language.<BR> It makes the searching system friendlier because you can give your desired book a tag.");
		echo "</FONT>";
		if (loginchk_lib("check")==true) {
			echo "<A HREF='./dublin.bibtag.hist.php?ID=$ID' target=_blank class=smaller2>[detail]";
			echo "</A>";
		}

	} // end if not addform
	?>
	<TABLE align=cetner >
<?php  echo $_pagesplit_btn_var;?>
</TABLE></TD>
</TR>

</TABLE>