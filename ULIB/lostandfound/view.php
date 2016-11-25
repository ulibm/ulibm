<?php 
	; 
        include ("../inc/config.inc.php");
		if (barcodeval_get("lostandfound_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}
		head();
        mn_web("lostandfound");
		if ($id!="" && $setnewcate!="" && library_gotpermission("lostandfound")==true) {
			tmq("update webpage_lostandfound set cate='$setnewcate' where id='$id' ");
		}
?>
<TABLE cellpadding=0 cellspacing=0 border=0 width="<?php  echo $_TBWIDTH?>" align=center>
<TR valign=top>
	<TD width=200><?php include("menu.php");?></TD>
		<TD align=right><BR>
		<?php 

		$s=tmq("select * from webpage_lostandfound where id='$id' ");
		$s=tmq_fetch_array($s);

		$catenamedb["new"]=getlang("รายการของหาย::l::Lost and found items");
		$catenamedb["destroy"]=getlang("รายการที่ทำลายทิ้งแล้ว::l::Abandoned items");
		$catenamedb["solved"]=getlang("มีผู้มารับแล้ว::l::Picked up items");
		$catenamedb["hide"]=getlang("รายการที่ถูกซ่อนไว้::l::Hidden Items");
		echo "<A HREF='index.php?cate=$s[cate]' class=smaller>";
		echo getlang("ในหัวข้อ ::l::In group ")."".$catenamedb[$s[cate]];
		echo "</A>";
		?>
		<TABLE width=100% class=table_border>
			<TR>
				<TD class=table_head  width=150><?php  echo getlang("ชื่อรายการ::l::Title");?></TD>
				<TD class=table_td><?php  echo stripslashes(strip_tags($s[title]))?></TD>
			</TR>
			<TR>
				<TD class=table_head><?php  echo getlang("รายละเอียดของหาย::l::Detail");?></TD>
				<TD class=table_td  style="padding: 20px; background-color: #E0E0E0"><?php  echo stripslashes(strip_tags($s[text]))?><HR noshade>
				<CENTER><?php 
if (file_exists("./attatch/$s[id]-1.jpg")) {
	echo "<img src='./attatch/$s[id]-1.jpg' vspace=10><BR>";
}
if (file_exists("./attatch/$s[id]-2.jpg")) {
	echo "<img src='./attatch/$s[id]-2.jpg'><BR>";
}
				?></CENTER>
				</TD>
			</TR>
			<?php 
			if (library_gotpermission("lostandfound") && $s[answer]<>'') {
			?><TR>
				<TD class=table_head><?php  echo getlang("รายละเอียดผู้มารับ::l::Owner detail");?></TD>
				<TD class=table_td style="padding: 20px; background-color: #C6FBCF"><?php  echo stripslashes(($s[answer]))?></TD>
			</TR><?php 
			}
			?>
			</TABLE>
		<?php 
if (library_gotpermission("lostandfound")) {

		pagesection(getlang("หากมีผู้มารับของ:รายละเอียดผู้มารับ::l::Owner pickup: Owner detail"),"article");

			?>
			<TABLE width=100% class=table_border>
<FORM METHOD=POST ACTION="answer.php">
			<TR>
				<TD class=table_head><?php  echo getlang("รายละเอียดผู้มารับ::l::Owner detail");?></TD>
				<TD class=table_td>
				<?php 
			html_htmlareajs();	
			?><TEXTAREA NAME="answer" ID="answer" ROWS="10" COLS="60"><?php  echo stripslashes($s[answer]);?></TEXTAREA></TD>
			</TR>

			<TR>
				<TD class=table_td align=center colspan=1><B><?php  echo getlang("ให้แท็ก::l::Tags");?>: </B></TD>
				<TD><?php 
			$ts=tmq("select * from webpage_lostandfound_tag order by name");
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
			<?php html_htmlarea_gen("answer");?>
			<TR>
				<TD class=table_td align=center colspan=2>
<INPUT TYPE="hidden" NAME="id" value="<?php echo $id;?>">
<?php  echo getlang("กำหนดสถานะ::l::Set status");?>: 
<SELECT NAME="setcateforans">
	<OPTION VALUE="solved" SELECTED><?php  echo getlang("มีผู้มารับแล้ว::l::Picked up items");?>
	<OPTION VALUE="destroy"><?php  echo getlang("รายการที่ทำลายทิ้งแล้ว::l::Abandoned items");?>
 </SELECT>
 
 <INPUT TYPE="submit" value=" Update "></TD>
			</TR>
			</FORM>
			</TABLE>
			<TABLE width=100% class=table_border>
<FORM METHOD=POST ACTION="view.php">
			<TR>
				<TD class=table_head><?php  echo getlang("ไม่ตอบ ย้ายไปที่::l::No answer, move to");?></TD>
				<TD class=table_td>

<SELECT NAME="setnewcate">
	<OPTION VALUE="new" SELECTED><?php  echo getlang("รายการของหาย::l::Lost and found items");?>
	<OPTION VALUE="solved"><?php  echo getlang("มีผู้มารับแล้ว::l::Picked up items");?>
	<OPTION VALUE="destroy"><?php  echo getlang("รายการที่ทำลายทิ้งแล้ว::l::Abandoned items");?>
	<OPTION VALUE="hide"><?php  echo getlang("รายการที่ซ่อนไว้::l::Hidden Items");?>
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