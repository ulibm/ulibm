<?php 
	; 
        include ("../inc/config.inc.php");
		if (barcodeval_get("answerpoint_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}
		head();
        mn_web("answerpoint");
		if ($id!="" && $setnewcate!="" && library_gotpermission("answerpoint")==true) {
			tmq("update webpage_answerpoint set cate='$setnewcate' where id='$id' ");
		}
?>
<TABLE cellpadding=0 cellspacing=0 border=0 width="<?php  echo $_TBWIDTH?>" align=center>
<TR valign=top>
	<TD width=200><?php include("menu.php");?></TD>
		<TD align=right><BR>
		<?php 

		$s=tmq("select * from webpage_answerpoint where id='$id' ");
		$s=tmq_fetch_array($s);

		$catenamedb["new"]=getlang("คำถามถูกตั้งใหม่::l::New Questtion");
		$catenamedb["wait"]=getlang("คำถามอยู่ระหว่างรอการวิเคราะห์::l::Waiting Question");
		$catenamedb["solved"]=getlang("คำถามที่ตอบแล้ว::l::Solved Question");
		$catenamedb["faq"]=getlang("คำถามพบบ่อย::l::FAQs");
		$catenamedb["hide"]=getlang("คำถามที่ถูกซ่อน::l::Hidden Question");
		echo "<A HREF='index.php?cate=$s[cate]' class=smaller>";
		echo getlang("ในหัวข้อ ::l::In group ")."".$catenamedb[$s[cate]];
		echo "</A>";
		?>
		<TABLE width=100% class=table_border>
			<TR>
				<TD class=table_head  width=150><?php  echo getlang("หัวข้อคำถาม::l::Topic");?></TD>
				<TD class=table_td><?php  echo stripslashes(strip_tags($s[title]))?></TD>
			</TR>
			<TR>
				<TD class=table_head><?php  echo getlang("ข้อความ<BR>คำถาม::l::Detail");?></TD>
				<TD class=table_td  style="padding: 20px; background-color: #E0E0E0"><?php  echo str_preformat(stripslashes(strip_tags($s[text])))?><HR noshade>
				<CENTER><?php 
if (file_exists("./attatch/$s[id]-1.jpg")) {
	echo "<img src='./attatch/$s[id]-1.jpg' vspace=10><BR>";
}
if (file_exists("./attatch/$s[id]-2.jpg")) {
	echo "<img src='./attatch/$s[id]-2.jpg'><BR>";
}
				?></CENTER>
<?php 

	$taglist=explode(',',$s[taglist]);
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
	echo "<FONT class=smaller2><BR>&nbsp;&nbsp;".getlang("เมื่อ::l::since");
	echo " ".ymd_datestr($s[dt]) . " (" .ymd_ago($s[dt]).")";
echo $tags."</FONT>";
?>				
				</TD>
			</TR>
			<?php 
			if ($s[answer]!=""||file_exists("./attatch/$s[id]-a1.jpg")||file_exists("./attatch/$s[id]-a2.jpg")||file_exists("./attatch/$s[id]-a3.jpg")) {
			?><TR>
				<TD class=table_head><?php  echo getlang("คำตอบ::l::Answer");?></TD>
				<TD class=table_td style="padding: 20px; background-color: #C6FBCF"><?php  echo stripslashes(($s[answer]))?><HR noshade>
				<CENTER><?php 
if (file_exists("./attatch/$s[id]-a1.jpg")) {
	echo "<img src='./attatch/$s[id]-a1.jpg' vspace=10><BR>";
}
if (file_exists("./attatch/$s[id]-a2.jpg")) {
	echo "<img src='./attatch/$s[id]-a2.jpg' vspace=10><BR>";
}
if (file_exists("./attatch/$s[id]-a3.jpg")) {
	echo "<img src='./attatch/$s[id]-a3.jpg' vspace=10>";
}
				?></CENTER></TD>
			</TR><?php 
			}
			?>
			</TABLE>
		<?php 
if (library_gotpermission("answerpoint")) {

		pagesection(getlang("ตอบคำถาม::l::Answer"),"article");

			?>
			<TABLE width=100% class=table_border>
<FORM METHOD=POST ACTION="answer.php" enctype="multipart/form-data">
			<TR>
				<TD class=table_head><?php  echo getlang("ตอบคำถาม::l::Answer Detail");?></TD>
				<TD class=table_td>
				<?php 
			html_htmlareajs();	
			?><TEXTAREA NAME="answer" ID="answer" ROWS="10" COLS="60"><?php  echo stripslashes($s[answer]);?></TEXTAREA></TD>
			</TR>
			<?php html_htmlarea_gen("answer");?>

			<TR>
				<TD class=table_td align=center colspan=2><B><?php  echo getlang("ภาพประกอบ 1::l::Attatch Image 1");?>: </B><input type=file name='img01'></TD>
			</TR>
			<TR>
				<TD class=table_td align=center colspan=2><B><?php  echo getlang("ภาพประกอบ 2::l::Attatch Image 2");?>: </B><input type=file name='img02'></TD>
			</TR>
			<TR>
				<TD class=table_td align=center colspan=2><B><?php  echo getlang("ภาพประกอบ 3::l:: Attatch Image 3");?>: </B><input type=file name='img03'><BR>
				*.JPG <?php  echo getlang("เท่านั้น, มีไฟล์ประกอบได้ 3 ภาพ หากอัพโหลดไฟล์หมายเลขเดิม ไฟล์จะไปทับภาพเก่า::l::Only, can attatch 3 photo. If upload the same photo ID , old photo will be overwritten.");?></TD>
			</TR>
			<TR>
				<TD class=table_td align=center colspan=1><B><?php  echo getlang("ให้แท็ก::l::Tags");?>: </B></TD>
				<TD><?php 
			$ts=tmq("select * from webpage_answerpoint_tag order by name");
			while ($tsr=tmq_fetch_array($ts)) {
				?><label><INPUT TYPE="checkbox" NAME="tags[]" value="<?php  echo $tsr[id]?>" style="border:0"
				<?php 
$pos = strpos("$s[taglist]", ",$tsr[id],");

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($pos === false) {
} else {
    echo " checked ";
}
				?>> <?php  echo getlang($tsr[name])?></label> <?php 
			}
			?><BR><A HREF="taglist.php" class=smaller><?php  echo getlang("แก้ไขแท็ก::l::Edit tags"); ?></A></TD>
			</TR>
			<TR>
				<TD class=table_td align=center colspan=2>
<INPUT TYPE="hidden" NAME="id" value="<?php echo $id;?>">
<?php  echo getlang("กำหนดสถานะ::l::Set status");?>: 
<SELECT NAME="setcateforans">
	<OPTION VALUE="solved" SELECTED><?php  echo getlang("คำถามที่ตอบแล้ว::l::Solved Question");?>
	<OPTION VALUE="wait"><?php  echo getlang("รอการวิเคราะห์::l::Waiting Question");?>
	<OPTION VALUE="faq"><?php  echo getlang("คำถามพบบ่อย::l::FAQs");?>
 </SELECT>
 
 <INPUT TYPE="submit" value=" Answer "></TD>
			</TR>
			</FORM>
			</TABLE>
			<TABLE width=100% class=table_border>
<FORM METHOD=POST ACTION="view.php">
			<TR>
				<TD class=table_head><?php  echo getlang("ไม่ตอบ ย้ายไปที่::l::No answer, move to");?></TD>
				<TD class=table_td>

<SELECT NAME="setnewcate">
	<OPTION VALUE="new" SELECTED><?php  echo getlang("คำถามใหม่::l::New question");?>
	<OPTION VALUE="wait"><?php  echo getlang("รอการวิเคราะห์::l::Waiting Question");?>
	<OPTION VALUE="solved"><?php  echo getlang("คำถามที่ตอบแล้ว::l::Solved Question");?>
	<OPTION VALUE="faq"><?php  echo getlang("คำถามพบบ่อย::l::FAQs");?>
	<OPTION VALUE="hide"><?php  echo getlang("คำถามที่ถูกซ่อน::l::Hidden Question");?>
 </SELECT> <INPUT TYPE="submit" value="<?php echo getlang("ย้าย::l::Move");?>"></TD>
			</TR>
<INPUT TYPE="hidden" NAME="id" value="<?php echo $id;?>">

			</FORM>
			</TABLE><?php 
		}
			?>
		</TD>

</TR>
</TABLE>
<?php 
				foot();
?>