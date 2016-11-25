<?php 
include("./inc/config.inc.php");
 include("./index.inc.php");

$click=floor($click);
if ($click!=0) {
	tmq("update freedb_link set clickcount=clickcount+1 where id='$click' ");
	$s=tmq("select * from freedb_link where id='$click'");
	$s=tmq_fetch_array($s);
	redir("$s[url]");
	die;
}


if ($save=="yes") {
	$s=tmq("select * from freedb_cate order by name");
	$someyes="no";
	while ($r=tmq_fetch_array($s)) {
		if ($fdblist[$r[id]]=="okyes") {
			$someyes="yes";
			eval("\$searchfreedb[$r[id]]='yes';");
		} else {
			eval("\$searchfreedb[$r[id]]='no';");
		}
	}
	if ($someyes=="yes") {
		ulibsess_register("searchfreedb");
	} else {
		ulibsess_unregister("searchfreedb");
	}
}

 stat_add("visithp_type","freedb");
head();
			mn_web("freedb");
//printr($searchfreedb);
$reportdeadlink=floor($reportdeadlink);
if ($reportdeadlink!=0) {
	tmq("update freedb_link set reportdeadlink=reportdeadlink+1 where id='$reportdeadlink' ");
	html_dialog("","ขอบคุณสำหรับการรายการ เจ้าหน้าที่จะนำข้อมูลไปตรวจสอบต่อไป::l::Thank you for reporting, officer will recheck this site soon.");
}

pagesection(getlang("กรุณาเลือกหัวข้อที่ต้องการสืบค้น และป้อนข้อความสำหรับสืบค้น::l::Please choose category and enter text to search from"));
?>
<TABLE width=780 align=center cellpadding=0 cellspacing=0  ID=WEBPAGE_BODY>
<FORM METHOD=POST ACTION="freedb.php">
	<TR valign=top>
	<TD align=center> <fieldset><legend><?php  echo getlang("หัวข้อที่ต้องการสืบค้น ::l::Category to search");?></legend>
	<TABLE cellpadding=10>
	<TR>
		<TD><?php 
$s=tmq("select * from freedb_cate order by name");
while ($r=tmq_fetch_array($s)) {
?><nobr><?php 
	echo "<img src='$dcrURL/neoimg/freedbicon/$r[icon].png' width=24 height=24 align=absmiddle>";
	?><INPUT TYPE="checkbox" NAME="fdblist[<?php echo $r[id]?>]" value="okyes" style="border-width: 0;" <?php 
  if ($searchfreedb[$r[id]]=="yes" || count($searchfreedb)==0) {
  	echo " checked ";
  }
  ?>> <B style='font-size: 18px; ' title="<?php  echo getlang($r[descr])?>"><?php  echo getlang($r[name])?></B></nobr>
  <?php 
}	
?><HR>
<?php  echo getlang("ใส่ข้อความสำหรับสืบค้น::l::Enter text to search");?>
	<input type="text" name="keyword" value="<?php  echo $keyword?>" />
	<INPUT TYPE="submit" value=" <?php  echo getlang("แสดง::l::Show");?>"> 
	</TD>
	</TR>
	</TABLE>
	</fieldset></TD>
</TR>
<TR>
	<TD colspan=2 align=center>

	<A HREF="index.php"><B><?php  echo getlang("กลับ::l::Back");?></B></A>
	
	</TD>
</TR>
<INPUT TYPE="hidden" NAME="save" value="yes">
</FORM>
</TABLE>
<?php 

$tbname="freedb_link";

//dsp
$dsp[2][text]="หัวข้อ::l::Category";
$dsp[2][align]="center";
$dsp[2][field]="nested";
$dsp[2][filter]="foreign:-localdb-,freedb_cate,id,name";
$dsp[2][width]="25%";

$dsp[3][text]="Name::l::Name";
$dsp[3][field]="name";
$dsp[3][filter]="module:localdsp";
$dsp[3][width]="70%";


$limit=" 1 ";
if ($keyword!="") {
	 $limit.=" and (name like '%$keyword%' or descr like '%$keyword%' or url like '%$keyword%') ";
}

////////start cate display
$freedbsql="";
if (is_array($searchfreedb) && count($searchfreedb)>0 )	 {
 $s=tmq("select * from freedb_cate ");
	while ($r=tmq_fetch_array($s)) {
			if ($searchfreedb[$r[id]]=="yes") {
				$freedbsql.=" or nested = $r[id]";
			}
		$tmp=trim($tmp,',');
	}

}
$freedbsql=trim($freedbsql);
if ($freedbsql!="") {
	$freedbsql= " and (0 $freedbsql)";
}

////////end cate display

function localdsp($wh) {
	global $tbname;
	global $cate;
	$img=fft_upload_get($tbname,"logoimg",$wh[id]);
	//printr($img);
	$simg="<img src='$img[url]' align=left width=100 border=0>";
	$s="<A HREF='freedb.php?click=$wh[id]' target=_blank>$simg<B>$wh[name]</B></A><BR>";
	$s.="<FONT class=smaller COLOR=darkgreen>$wh[url]</FONT><BR>";
	$s.="$wh[descr]<BR><FONT class=smaller>".getlang("เยี่ยมชม $wh[clickcount] ครั้ง::l::Visit $wh[clickcount] times")." : <A HREF='freedb.php?reportdeadlink=$wh[id]' onclick=\"return confirm('Report this website as dead link?');\" class=smaller2 style='color: darkred'>".getlang("แจ้งลิงค์เสีย::l:: Report dead link")."</A></FONT> ";;

	return $s;
}

$limit.=$freedbsql;
//echo "[$limit]";
fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","keyword=$keyword",$c);



foot();
?>