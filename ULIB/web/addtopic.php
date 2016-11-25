<?php 
;
include("./cfg.inc.php");
include("./_localfunc.php");
head();
mn_web($_REQPERM);
               
	$iseditpermmanager=library_gotpermission("webeditpagepermission");
	$ismanager=library_gotpermission("webpage-postarticle");
	 $ID=trim($ID);
	 $editing=trim($editing);
?><BR><?php 
	if ($replying!="") {
		$replyingdb=tmq("select * from webpage_articles where id='$replying' ");
		if (tmq_num_rows($replyingdb)==0) {
			die("no webpage_articles id $editing to reply.");
		}
		$replyingdb=tmq_fetch_array($replyingdb);
		$editdata[topic]=addslashes("ตอบ:".$replyingdb[topic]);
		$postdata[topic]=addslashes($replyingdb[topic]);
	}

pathgen($ID,$replying);

	if (($catedata[isshowtouser]!="yes" && $ismanager!=true) && $ID!="index") {
		die("you cannot post in this forum");
	}
	if ($editing!="") {
		//echo "web-id-$editing";
		if (editperm_chk("web-id-$editing")!=true) {
			die ("คุณไม่มีสิทธิ์ลบหรือแก้ไขรายการนี้::l::Your login have no permission to modify this article;");
		}
		$editdata=tmq("select * from webpage_articles where id='$editing' ",false);
		if (tmq_num_rows($editdata)==0) {
			die("no webpage_articles id $editing to edit.");
		}
		$editdata=tmq_fetch_array($editdata);
		$editdata[topic]=addslashes($editdata[topic]);
		$editdata[text]=addslashes($editdata[text]);
	}
?>

<table width = "<?php  echo $_TBWIDTH?>" align=center border = "0" cellspacing = "1" cellpadding = "4" align = "center" bgcolor = e3e3e3>


<form name = "form1" method = "post" action = "addtopicaction.php" onsubmit="return chk(this);"><SCRIPT LANGUAGE="JavaScript">
<!--
function chk(wh) {
	if (wh.topic.value=="" || wh.topic.value==" " ) {
		alert("<?php  echo getlang("กรุณากรอกชื่อกระทู้ด้วย::l::Please enter topic");?>");
		return false;
	}
	if (wh.text.value=="" || wh.text.value==" " ) {
		alert("<?php  echo getlang("กรุณากรอกข้อความสำหรับกระทู้ด้วย::l::Please enter some question");?>");
		return false;
	}
}
//-->
								</SCRIPT>
                                        <tr bgcolor = "#f3f3f3">

                                            <td width = "20%" valign = "middle" class=table_head>

                                                <font face = "MS Sans Serif" size = "2"><?php  echo getlang("ชื่อบทความ::l::Topic");?><br> </font></td>

                                            <td >

                                                <font face = "MS Sans Serif" size = "2"><input type = text name = "topic" size=45 value="<?php  echo $editdata[topic];?>" ID='topic'> </font></td>

                                        </tr>

<?php 
	echo "<INPUT TYPE=hidden NAME='ID' value='$ID'>";

?>
                                        <tr bgcolor = "#f3f3f3">

                                            <td  valign = "middle" class=table_head>

                                                <font face = "MS Sans Serif" size = "2"><?php  echo getlang("ข้อความ::l::Question");?><br> </font></td>

                                            <td >

                                                <font face = "MS Sans Serif" size = "2"><TEXTAREA NAME="text" ID="text" ROWS="10" COLS="73" style="height: 520"><?php 
												echo stripslashes($editdata[text]);
												if ($quote!="") {
													echo "<BR><BR><BR>";
													$quotedb=tmq("select * from webpage_articles where id='$quote' ");
													if (tmq_num_rows($quotedb)==0) {
														$quotedb=("no webpage_articles id $editing to quote.");
													} else {
														$quotedb=tmq_fetch_array($quotedb);
														$quotedba=get_library_name($quotedb[tmid]);
														$quotedb=stripslashes($quotedb[text]);
													}

													echo "<TABLE width=90% style=\"border-color: 777777; border-style: solid; border-width: 1px; background-color: #f0f0f0\" align=center><TR><TD  style=\" background-color: #e0e0e0;\" ><B>$quotedba</B> ".getlang("พิมพ์ว่า::l::Says").":</TD></TR><TR><TD style=\"padding-left: 10px;\">$quotedb</TD></TR></TABLE>";
												}
												?></TEXTAREA></font></td>

                                        </tr>

<?php 
html_htmlareajs("text");
html_htmlarea_gen("text");
	if ($ismanager!=true ) {
?>
	<tr bgcolor = "#f3f3f3">
		<td width = "20%" valign = "middle" class=table_head>
			<font face = "MS Sans Serif" size = "2"><?php  echo getlang("ผู้โพสท์::l::Your name");?><br> </font></td>
		<td >
			<font face = "MS Sans Serif" size = "2"><input type = text name = "postername" size=45 value="<?php  echo $editdata[postername];?>" ID='postername'> </font></td>
	</tr>
	<tr bgcolor = "#f3f3f3">
		<td width = "20%" valign = "middle" class=table_head>
			<font face = "MS Sans Serif" size = "2"><?php  echo getlang("อีเมล์ผู้โพสท์::l::Your E-mail");?><br> </font></td>
		<td >
			<font face = "MS Sans Serif" size = "2"><input type = text name = "postermail" size=45 value="<?php  echo $editdata[postermail];?>" ID='postermail'> </font></td>
	</tr>

<?php 
	}
	if ($ismanager==true ) {

?>
<tr>
	<td  class=table_head><?php  echo getlang("ปักหมุดข้อความนี้::l::Pin this topic");?>:</td>
	<td >
		<SELECT NAME="ispin">
		<option <?php if ($editdata[ispin]=="yes") { echo "selected"; }?>>yes
		<option <?php if ($editdata[ispin]=="no" || $editdata[ispin]=="") { echo "selected"; }?>>no
		</SELECT>
	</td>
</tr>
<tr>
	<td  class=table_head><?php  echo getlang("อนุญาตการตอบ::l::Can reply?");?>:</td>
	<td >
		<SELECT NAME="iscan_ans">
		<option <?php if ($editdata[iscan_ans]=="yes" || $editdata[iscan_ans]=="") { echo "selected"; }?>>yes
		<option <?php if ($editdata[iscan_ans]=="no") { echo "selected"; }?>>no
		</SELECT>
	</td>
</tr>
<tr>
	<td  class=table_head><?php  echo getlang("ซ่อนไว้::l::Hidden topic?");?>:</td>
	<td >
		<SELECT NAME="ishide">
		<option <?php if ($editdata[ishide]=="yes") { echo "selected"; }?>>yes
		<option <?php if ($editdata[ishide]=="no" || $editdata[ishide]=="") { echo "selected"; }?>>no
		</SELECT>
	</td>
</tr>
<?php 
if ($editing!="" && $iseditpermmanager==true) {
?>
<tr>
	<td  class=table_head><?php  echo getlang("สิทธิ์การแก้ไข::l::Edit permission");?>:</td>
	<td ><?php 
editperm_form("web-id-$editing");	
?>
	</td>
</tr>
<?php 
}
?>

<?php 
	} else {
	?>
	<input type=hidden name=ishide value="<?php  echo barcodeval_get("webboard-reviewfirst")?>">
	<?php 	
	}
	?>

			<tr bgcolor = "#f3f3f3">
			<td  valign = "middle" class=table_head>
				<font face = "MS Sans Serif" size = "2"><?php  echo getlang("แนบไฟล์::l::Attatchment");?><br> </font></td>
			<td ><iframe width=600 height=150 src="attach.php?ID=<?php  echo $ID;?>&editing=<?php  echo $editing;?>"></iframe></td>
		</tr>
                                        <tr bgcolor = "#e3e3e3">

                                            <td colspan=2 align=center>

                                                <font face = "MS Sans Serif" size = "2">

												<input type = "submit" name = "Submit2" ID = "Submit2" value = " <?php  echo getlang("ส่งข้อมูล::l::Submit");?> " style="font-weight: bold;">
												<input type = "reset" name = "Reset" value = " <?php  echo getlang("ลบข้อมูล::l::Reset");?> ">
												<?php  if ($backto!="") {?>
												<input type = "reset" name = "Reset" value = " <?php  echo getlang("กลับ::l::Back");?> " onclick="self.location='<?php  echo $backto?>' ">
												<?php }?>
												</font><BR><BR></td>

<INPUT TYPE="hidden" NAME="replying" value="<?php  echo $replying?>">
<INPUT TYPE="hidden" NAME="editing" value="<?php  echo $editing?>">
<INPUT TYPE="hidden" NAME="picalbum" value="<?php  echo $picalbum?>">

                                        </tr>

                                </form>

                                    </table>

<?php 

pathgen($ID,$replying);

if ($replying!="") {
?><BR><BR><TABLE width="<?php  echo $_TBWIDTH?>" align=center class=table_border>
<TR>
	<TD class=table_head><?php  echo getlang("ข้อมูลการตอบเก่า::l::Previous webpage_articles");?></TD>
</TR>
		<tr bgcolor = "#f3f3f3">
			<td  class=table_td align=center><iframe width=760 height=300 src="addtopic.viewhist.php?TID=<?php  echo $replying;?>"></iframe></td>
		</tr>
</TABLE><BR><?php 
pathgen($ID,$replying);

}

include("inc.webjump.php");

foot();
?>