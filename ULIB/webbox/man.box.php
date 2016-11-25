<?php 
include("../inc/config.inc.php");

if ($issave=="yes") {
	if ($savetype==getlang("ลบกล่องนี้::l::Delete this box")) {
		tmq("delete from webbox_box where id='$id' ");
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
   if(self==top){
      top.location = "<?php echo $dcrURL;?>";
   } else {
      top.location.reload();
   }	//-->
	</SCRIPT><?php 
		die;
	}
	if ($savetype==getlang("ซ่อนกล่องนี้::l::Hide this box")) {
		tmq("update webbox_box set ishide='yes' where id='$id' ");
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
   if(self==top){
      top.location = "<?php echo $dcrURL;?>";
   } else {
      top.location.reload();
   }	//-->
	</SCRIPT><?php 
		die;
	}
	if ($savetype==getlang("แสดงกล่องนี้::l::Unhide this box")) {
		tmq("update webbox_box set ishide='no' where id='$id' ");
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
   if(self==top){
      top.location = "<?php echo $dcrURL;?>";
   } else {
      top.location.reload();
   }	//-->
	</SCRIPT><?php 
		die;
	}	if ($id=="") { //new
		$title=addslashes($title);
		tmq("insert into webbox_box set tab='$tab' , col=1, ordr=0,title='$title', type='$type',border_style='$border_style', border_width='$border_width',border_color='$border_color' ,hideheader='$hideheader',bg_color='$bg_color',boxradius='$boxradius'");
		$id=tmq_insert_id();
	} else { //save edit
		tmq("update webbox_box set tab='$tab' , title='$title', type='$type',border_style='$border_style', border_width='$border_width',border_color='$border_color',hideheader='$hideheader',bg_color='$bg_color',boxradius='$boxradius' where id='$id' ");
	}
	if ($savetype==getlang("บันทึกและปิด::l::Save and close")) {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
   if(self==top){
      top.location = "<?php echo $dcrURL;?>";
   } else {
      top.location.reload();
   }
		
	//-->
	</SCRIPT><?php 
		die;
	}
	if ($type=="eventcalendar") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
   if(self==top){
      top.location = "<?php echo $dcrURL;?>";
   } else {
      top.location.reload();
   }	//-->
	</SCRIPT><?php 
	}
	if ($type=="searchbox") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
   if(self==top){
      top.location = "<?php echo $dcrURL;?>";
   } else {
      top.location.reload();
   }	//-->
	</SCRIPT><?php 
	}
	if ($type=="photonews") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
   if(self==top){
      top.location = "<?php echo $dcrURL;?>";
   } else {
      top.location.reload();
   }	//-->
	</SCRIPT><?php 
	}
	if ($type=="webboardcate") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
   if(self==top){
      top.location = "<?php echo $dcrURL;?>";
   } else {
      top.location.reload();
   }	//-->
	</SCRIPT><?php 
	}
	if ($type=="webpageshowcase") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
   if(self==top){
      top.location = "<?php echo $dcrURL;?>";
   } else {
      top.location.reload();
   }	//-->
	</SCRIPT><?php 
	}
	if ($type=="mocalen") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
   if(self==top){
      top.location = "<?php echo $dcrURL;?>";
   } else {
      top.location.reload();
   }	//-->
	</SCRIPT><?php 
	}
	if ($type=="weeklybook") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
   if(self==top){
      top.location = "<?php echo $dcrURL;?>";
   } else {
      top.location.reload();
   }	//-->
	</SCRIPT><?php 
	}
	if ($type=="tab") {
		redir("man.box.tab.php?pid=$id");
	}
	if ($type=="photoframesingle") {
		redir("man.box.photoframesingle.php?pid=$id");
	}
	if ($type=="newslist") {
		redir("man.box.newslist.php?pid=$id");
	}
	if ($type=="calendar2") {
		redir("man.box.calendar2.php?pid=$id");
	}
	if ($type=="rss") {
		redir("man.box.rss.php?id=$id");
	}
	if ($type=="html") {
		redir("man.box.html.php?id=$id");
	}
	if ($type=="googlemap") {
		redir("man.box.googlemap.php?id=$id");
	}

	die;
}

include("$dcrs/webbox/config.php");
include("$dcrs/webbox/func.php");
html_start();

?><FORM METHOD=POST ACTION="man.box.php">
	
<TABLE width=1000 align=center border=0>
<TR>
	<TD colspan=3 class=table_head><?php 
		if ($mode=="add") {
			echo getlang("เพิ่มกล่องใหม่::l::Add new box");
			$s=Array();
		} else {
			echo getlang("แก้ไข::l::Edit box");
			$s=tmq("select * from webbox_box where id='$id' ");
			$s=tmq_fetch_array($s);
		}
	?></TD>
</TR>

<INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
<INPUT TYPE="hidden" NAME="tab" value="<?php  echo $tab;?>">
<INPUT TYPE="hidden" NAME="issave" value="yes">
<TR>
	<TD><?php  echo getlang("ชื่อกล่อง::l::Box Title");?></TD>
	<TD><?php  form_quickedit("title",$s[title],"text");?></TD>
	<TD rowspan=8 width=300 align=center ><?php  ?><div ID=boxtypediv style="height:300px"></div></TD>
</TR>

<TR>
	<TD><?php  echo getlang("ประเภท::l::Box Type");?></TD>
	<TD><?php  $jsid=form_quickedit("type",$s[type],"foreign:-localdb-,webbox_boxtype,classid,name");?></TD>
</TR>
<script>
var lastlocalboxtype="";
function localboxtypedsp() {
   tmp=getobj('<?php echo $jsid;?>');
   tmpdsp=getobj('boxtypediv');
   tmpv=tmp.options[tmp.selectedIndex].value+"";
   if (tmpv==lastlocalboxtype) return;
   lastlocalboxtype=tmpv;
   tmpdsp.innerHTML="<img src='<?php echo $dcrURL;?>neoimg/webboxtype/"+tmpv+".png' width=200>";
   console.log(tmpv);
}
setInterval("localboxtypedsp();",200);
</script>
<TR>
	<TD><?php  echo getlang("ซ่อนส่วนหัว::l::Hide header");?></TD>
	<TD><?php  form_quickedit("hideheader",$s[hideheader],"yesno");?></TD>
</TR>
<TR>
	<TD><?php  echo getlang("ลักษณะเส้นขอบ::l::Border style");?></TD>
	<TD><?php  form_quickedit("border_style",$s[border_style],"list:Solid,Dotted");?></TD>
</TR>
<TR>
	<TD><?php  echo getlang("ความโค้งของมุม::l::Box Radius");?></TD>
	<TD><?php  
	if ($s[boxradius]=="") {
		@$s[boxradius]=3;
	}
	form_quickedit("boxradius",$s[boxradius],"number");?></TD>
</TR>
<TR>
	<TD><?php  echo getlang("ขนาดเส้นขอบ::l::Border Size");?></TD>
	<TD><?php  
	if ($s[border_width]=="") {
		@$s[border_width]=1;
	}
	form_quickedit("border_width",$s[border_width],"number");?></TD>
</TR>
<TR>
	<TD><?php  echo getlang("สีเส้นขอบ::l::Border Color");?></TD>
	<TD><?php  form_quickedit("border_color",$s[border_color],"color");?></TD>
</TR>
<TR>
	<TD><?php  echo getlang("สีพื้นหลัง::l::Background Color");?></TD>
	<TD><?php  form_quickedit("bg_color",$s[bg_color],"color");?></TD>
</TR>
<TR>
	<TD colspan=3 class=table_head><!-- <INPUT TYPE="submit" name=savetype value="<?php  echo getlang("ขั้นต่อไป::l::Next"); ?>"> -->
	<INPUT TYPE="submit" name=savetype value="<?php  echo getlang("บันทึกและปิด::l::Save and close"); ?>"> 
	<?php if ($s[ishide]!="yes") {
   	?><INPUT TYPE="submit" name=savetype value="<?php  echo getlang("ซ่อนกล่องนี้::l::Hide this box"); ?>" style="color: darkblue;"><?php
   } else {
      ?><INPUT TYPE="submit" name=savetype value="<?php  echo getlang("แสดงกล่องนี้::l::Unhide this box"); ?>" style="color: darkblue;"><?php
   } ?>
	<INPUT TYPE="submit" name=savetype value="<?php  echo getlang("ลบกล่องนี้::l::Delete this box"); ?>" onclick="return confirm('<?php  echo getlang("กรุณายืนยันการลบ::l::Please confirm deletion");?>');" style="color: red;">
	 </TD>
</TR>
</TABLE>
</FORM>