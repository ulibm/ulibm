<?php 
include("./inc/config.inc.php");

if ($instantset!="") {
	unset($usecollection);
	ulibsess_unregister("usecollection");
	$usecollection=Array();
	eval("\$usecollection[$instantset]='yes';");
	$disablereselectcollection="yes";
	ulibsess_register("usecollection");
	ulibsess_register("disablereselectcollection");
	//printr($_SESSION);die;
	redir("index.php?forcehpmode=advsearch");

}

include("./index.inc.php");

if ($disablereselectcollection=="yes") {
head();
mn_web("collections");
//printr($usecollection);
	pagesection(getlang("คอลเล็กชั่นที่กำลังค้นหา::l::Current Collection"));
?>
<TABLE width=500 align=center cellpadding=0 cellspacing=0>
	<?php 
list($getkey,$getval)=each($usecollection);
$s=tmq("select * from collections where id='$getkey' order by name");
$r=tmq_fetch_array($s);
?><TR valign=top>
	<TD width=64><?php 
	echo "<img src='$dcrURL/neoimg/collectionicon/$r[icon]' width=64 height=64>";

?></TD>
	<TD align=left width=100%>
	<B style='font-size: 24px; '>&nbsp;<?php  echo getlang($r[name])?></B><BR>
	<FONT class=smaller><?php  echo getlang($r[descr])?></FONT></TD>
</TR>
<TR>
	<TD colspan=2 align=center><BR><BR>
<?php 
	echo getlang("คุณไม่สามารถเลือกสืบค้นคอลเล็กชั่นอื่น ๆ ได้ เนื่องจากเจ้าหน้าที่กำหนดให้สืบค้นได้จากคอลเล็กชั่นนี้เท่านั้น หากมีข้อสงสัยกรุณาติดต่อเจ้าหน้าที่::l::You cannot choose other collection because officer set this collection as defaults for this PC, contact officer for further information. ");
?>
	<BR>
	<A HREF="index.php"><B><?php  echo getlang("กลับ::l::Back");?></B></A>
	
	</TD>
</TR>

<?php 
	foot();
	die;
}

if ($setall=="yes") {
	$someyes="yes";
	ulibsess_unregister("usecollection");
	redir("index.php?forcehpmode=advsearch");
	die;
}



if ($save=="yes") {
	$s=tmq("select * from collections order by name");
	$someyes="no";
	$usecollection=Array();
	while ($r=tmq_fetch_array($s)) {
		if ($collist[$r[id]]=="okyes") {
			$someyes="yes";
			eval("\$usecollection[$r[id]]='yes';");
		} else {
			eval("\$usecollection[$r[id]]='no';");
		}
	}
	if ($someyes=="yes") {
		ulibsess_register("usecollection");
	} else {
		ulibsess_unregister("usecollection");
	}
	//printr($usecollection);
	redir("index.php?forcehpmode=advsearch");
	die;

}

head();
mn_web("collections");

//printr($usecollection);

pagesection(getlang("กรุณาเลือกคอลเลกชั่นที่ต้องการสืบค้น::l::Please choose collections to search from"));
	if ($someyes!="yes") {
		//html_dialog("",getlang("กรุณาเลือกคอลเล็กชัน::l::Please choose some collection"));
	} else {
		html_dialog("Success",getlang("บันทึกค่าเรียบร้อยแล้ว::l::Collection selected") . "   ..<A HREF='index.php'><B>".getlang("กลับหน้าสืบค้น::l::Back to search form")."</B></A>");
	}
?><BR>
<TABLE width=550 align=center cellpadding=0 cellspacing=0>
<FORM METHOD=POST ACTION="collections.php">
<INPUT TYPE="hidden" NAME="save" value="yes">
	<?php 
$s=tmq("select * from collections order by name");
while ($r=tmq_fetch_array($s)) {
?><TR valign=top>
	<TD width=64><?php 
	echo "<img src='$dcrURL/neoimg/collectionicon/$r[icon]' width=64 height=64>";

?></TD>
	<TD align=left width=100%><INPUT TYPE="checkbox" NAME="collist[<?php echo $r[id]?>]"  ID="collist[<?php echo $r[id]?>]" value="okyes" style="border-width: 0;"
<?php 
if ($usecollection[$r[id]]=="yes") {
	echo " checked ";
}
?>
	>
	<label for="collist[<?php echo $r[id]?>]"><B style='font-size: 24px; '><?php  echo getlang($r[name])?></B><BR>
	<FONT class=smaller><?php  echo getlang($r[descr])?></FONT></label><BR><BR></TD>
</TR>
<?php 
}	
?>
<TR>
	<TD colspan=2 align=center><INPUT TYPE="submit" value=" <?php  echo getlang("ใช้คอลเลกชันที่เลือก::l::Use selected collections");?>"> 
	 :: <A HREF="collections.php?setall=yes"  class=a_btn><?php  echo getlang("ไม่กำหนดคอลเล็กชัน::l::Do not limit by collections");?></A> :: 
	<A HREF="index.php" class=a_btn><B><?php  echo getlang("กลับ::l::Back");?></B></A>
<BR><BR>
	<A HREF="collections-about.php" class=a_btn><B><?php  echo getlang("เกี่ยวกับคอลเล็กชั่นต่าง ๆ::l::About Collections");?></B></A>

	</TD>
</TR>
</FORM>
</TABLE>
<?php 
foot();
?>