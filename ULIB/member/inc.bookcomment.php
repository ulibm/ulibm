<CENTER><?php 

if ($_memid!="") { 
	$requestdeletecomment=floor($requestdeletecomment);
	if ($requestdeletecomment!=0) {
		tmq("update webpage_bookcomment set reportdelete=reportdelete+1,reportdeletemem=concat(',',reportdeletemem,',$_memid,') where id='$requestdeletecomment' ");
	}

}	
$now=time();
		pagesection(getlang(barcodeval_get("bookcomment_name")),"bookcomment");
$bibtitle=stripslashes(str_remspecialsign(marc_gettitle($ID)));
if (mb_strlen($bibtitle)>20) {
	$bibtitle=mb_substr($bibtitle,0,18).'..';
}
?>
<?php 

if (!function_exists("local_addcommentbtn")) {
	function local_addcommentbtn() {
		global $_memid;
		global $bookcommentform;
		global $bibtitle;
		global $_TBWIDTH;
		global $ID;
		global $dcrURL;
		?><table width = "<?php  echo $_TBWIDTH?>" align=center border = "0" cellspacing = "1" cellpadding = "3" bgcolor = "#bbbbbb" >    <tr bgcolor = dddddd>
        <td align=right><?php 
if ($bookcommentform!="yes" ) {
	echo getlang("คอมเมนท์ทรัพยากรรายการนี้::l::Comment this record");
} else {
	echo getlang("กรุณากรอกข้อความของคุณ::l::Please enter your comment.");
}?></td>
				<td width=100 ><?php 
		if ($_memid!="") { 
			if ($bookcommentform!="yes") {
				html_xpbtn(getlang("เพิ่มคอมเมนท์::l::Add comment").":$bibtitle".",$dcrURL/dublin.php?ID=$ID&bookcommentform=yes#bookcommentform,green");
			} else {
				html_xpbtn(getlang("ยกเลิก::l::Cancel").",$dcrURL/dublin.php?ID=$ID#bookcommentlist,green");
			}
		} else {
			html_xpbtn(getlang("คอมเมนท์::l::Add comment.").":$bibtitle".",$dcrURL/member/?backto=".urlencode("$dcrURL/dublin.php?ID=$ID&bookcommentform=yes#bookcommentform").",red");
		}
		if (loginchk_lib("check")) {
			html_xpbtn(getlang("ข้อมูลการ Comment::l::Comment Info")."".",$dcrURL/dublin.commentlog.php?ID=$ID,blue");
		}	
		?></td>
    </tr></table>
<?php 
	}
}

///save module start
if ($savebookcomment=="yes" && $isagree=="yes" && $_memid!="") {
	$commentdata=addslashes($commentdata);
	$bookcomment_instantshow=barcodeval_get("bookcomment_instantshow");
	$inscmnt="insert into webpage_bookcomment set bibid='$ID', memid='$_memid', body='$commentdata', allowed='$bookcomment_instantshow', dt='$now',isspoil='$isspoil' ";
	if ($bookcomment_instantshow!="yes") {
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
			alert("<?php  echo getlang("ขอบคุณสำหรับคอมเมนท์ กรุณารอเจ้าหน้าที่ตรวจสอบ ข้อความที่คุณป้อนจะแสดงภายหลัง::l::Thank you for your comment, your comment will show after official verified.");?>");
		//-->
		</SCRIPT><?php 
	}
	tmq($inscmnt);
}
///save module end
$cmnts=tmqp("select * from webpage_bookcomment where bibid='$ID' and allowed='yes' order by dt desc","dublin.php?ID=$ID","<BR>ยังไม่เคยถูกคอมเมนท์<BR><BR>::l::<BR>Never been commented<BR><BR>",5);
$cmntcount=0;
if (tmq_num_rows($cmnts)!=0) {
	local_addcommentbtn();
	echo $_pagesplit_btn_var;
}
?><tr><td><?php 
///start disp comment

?><A name="bookcommentlist"></A><?php 
while ($cmntr=tmq_fetch_array($cmnts)) {
	$cmntcount++;
	?><TABLE width="<?php  echo $_TBWIDTH-50?>" align=center cellpadding=2 cellspacing=0 bgcolor=white>
	<TR valign=top>
		<TD width=120><?php echo html_membericon($cmntr[memid]);?></TD>
		<TD width=100% height=100% style="background-image: url('./member/miscimg/bookcommentbgb.png'); background-position: bottom; background-repeat: repeat-x;"><TABLE cellpadding=0 cellspacing=0 border=0 width=100% height=100%>
		<TR valign=top>
			<TD align=left valign=top style="border-width:0px ; border-color: eeeeee; border-style: solid; border-top-width: 1px; border-left-width: 2px; padding: 3" width=100%>

	<?php 
	if ($cmntr[isspoil]=="yes") {
		echo "<div ID='spoilerctrl$cmntr[id]'><FONT class=smaller2 style='color: #800000'><B>".getlang("ระวังเสียอรรถรส::l::This is Spoil!")."</B><BR>";
		echo getlang("ความคิดเห็นนี้มีเนื้อหาบางส่วนที่บอกเล่าเนื้อหาหรือฉากจบ::l::This comment contain story or ending scence.");;
		echo "</FONT> <A HREF='javascript:void(null)' class=smaller
		onclick=\"tmp=getobj('spoilerctrl$cmntr[id]');tmp.style.display='none'; tmp=getobj('spoilerdata$cmntr[id]'); tmp.style.display='block'; \">".getlang("คลิกเพื่อดู::l::Click to view")."</A></div>";
	}	
	?>			<div ID='spoilerdata<?php  echo $cmntr[id];?>' <?php 
	if ($cmntr[isspoil]=="yes") {
		echo "style='display:none'";
	}	
	?>><?php  echo str_censor(stripslashes($cmntr[body]));?></div></TD>
			<TD align=right valign=top width=125 height=132 background='./member/miscimg/bookcommentbg.png' 
			style="padding-top:80; padding-left:0; background-position: top right; background-repeat: no-repeat; padding-right:7"><img src="./neoimg/spacer.gif" width=125 height=10 hspace=0 vspace=0 border=0><BR><B><FONT class=smaller2 COLOR="#8F8F8F">#<?php  echo ($cmntcount+$startrow)?>&nbsp;</FONT></B></TD>
		</TR>
		<TR>
			<TD colspan=2><FONT style="" class=smaller2 COLOR="888888"><?php  echo getlang("เมื่อ::l::Since");?> <?php  echo ymd_datestr($cmntr[dt]);?> (<?php  echo ymd_ago($cmntr[dt])?>)</FONT><?php 
	$chkdsprqd=tmq("select id from webpage_bookcomment where id='$cmntr[id]' and reportdeletemem like '%,$_memid,%' ",false);	
	if (tmq_num_rows($chkdsprqd)==0) {
	?><A HREF="<?php  echo $dcrURL;?>dublin.php?ID=<?php  echo $ID?>&requestdeletecomment=<?php echo $cmntr[id]?>" onclick="return confirm('Please confirm');"><FONT style='color:darkred' class=smaller2>
			<?php 
	echo getlang("แจ้งลบ::l::Report");
	?>
			</FONT></A><?php 
	}
	?></TD>
		</TR>
		</TABLE></TD>
	</TR>
	</TABLE><?php 
}
//end dispcomment
?></td></tr><?php 
echo $_pagesplit_btn_var;

if ($bookcommentform=='yes' && $_memid!="") {
	?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function chkagree(wh) {
		if (wh.isagree.checked!=true) {
			alert("<?php  echo getlang("กรุณายอมรับเงื่อนไขในการใช้งาน::l::Please agree with terms and conditions");?>");
			return false
		}
		return true;
	}
//-->
</SCRIPT><A name="bookcommentform"></A><TABLE  width="560" align=center>
<FORM METHOD=POST ACTION="dublin.php?ID=<?php  echo $ID?>#bookcommentlist" onsubmit="return chkagree(this);">
	<TR><INPUT TYPE="hidden" NAME="savebookcomment" value="yes">
		<TD colspan=2><?php 
		form_quickedit("commentdata","","html");
		?></TD>
	</TR>
	<TR>
		<TD colspan=2 ><div align=right width="<?php  echo $_TBWIDTH-20?>"><label style="font-weight:bold; color: #990000; text-align:right"><INPUT TYPE="checkbox" NAME="isspoil" value="yes"> <?php  echo getlang("ระวังเสียอรรถรส::l::Spoil!");?></label><BR> <?php  echo getlang("โพสท์นี้มีเนื้อหาบางส่วนเกี่ยวกับเนื้อเรื่อง");?><BR></div></TD>
	</TR>	
	<TR>
		<TD colspan=2 noclass=table_td align=center><div align=left style="text-align:left; width: 600"><BR><?php 	
			echo barcodeval_get("bookcomment_agreement");
		?></div></TD>
	</TR>
	<TR>
		<TD colspan=2 noclass=table_td align=center> <label><INPUT TYPE="checkbox" NAME="isagree" style="border:0" value='yes'> <?php  echo getlang("ข้าพเจ้ายอมรับเงื่อนไขในการใช้งาน::l::I agree with terms and conditions");?></label><BR>
		<INPUT TYPE="submit" value=" <?php  echo getlang("ตกลง::l::Submit");?> "></TD>
	</TR>
	
	</FORM>
<?php  }
	local_addcommentbtn();
	?>
</table><?php 
		?></CENTER>