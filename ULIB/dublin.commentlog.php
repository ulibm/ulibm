<?php 
include("./inc/config.inc.php");

$clearreportdelete=floor($clearreportdelete);
if ($clearreportdelete!=0) {
	tmq("update webpage_bookcomment set reportdelete='0' where id='$clearreportdelete' ");
}
if ($mode=="chk") {
	html_start();
	if ($allowid=="yes") {
		tmq("update webpage_bookcomment set allowed='yes' where id='$chkid' ");
	}
	if ($cancelid=="yes") {
		tmq("update webpage_bookcomment set allowed='no' where id='$chkid' ");
	}
	$chk=tmq("select * from webpage_bookcomment where id='$chkid' ");
	$chk=tmq_fetch_array($chk);
	if ($chk[allowed]=="yes") {
		echo "<B style='font-size: 15; color: darkgreen'>อนุญาตแล้ว</B> <A HREF='dublin.commentlog.php?mode=chk&chkid=$chkid&cancelid=yes' style='font-size:12; color: darkred'>ยกเลิก</A>";
	} else {
		echo "<B style='font-size: 15; color: darkred'>ยังไม่อนุญาต</B> <A HREF='dublin.commentlog.php?mode=chk&chkid=$chkid&allowid=yes' style='font-size:12; color: darkgreen'>อนุญาต</A>";
	}

	die;
}

head();
$_REQPERM="bookcomment";
mn_lib();
$tbname="webpage_bookcomment";
//printr($selectlist);
$now=time();
echo "<center>";
?><BR><TABLE width=500 align=center>
<TR>
	<TD><?php 
			res_brief_dsp($ID);
?></TD>
</TR>
</TABLE><?php 
if ($issave=="yes" && count($selectlist)>0) {
  	if ($submitaction=="Delete Selected") {
		while (list($k,$v)=each($selectlist)) {
			tmq("delete from webpage_bookcomment where id='$v' ",false);
		}
	}
}
echo "</center>";

$c[2][text]="Member id";
$c[2][field]="memid";
$c[2][fieldtype]="readonlytext";
$c[2][descr]="";
$c[2][defval]="";

$c[11][text]="Librarian";
$c[11][field]="libid";
$c[11][fieldtype]="readonlytext";
$c[11][descr]="";
$c[11][defval]=$useradminid;


$c[3][text]="Tag";
$c[3][field]="word1";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[9][text]="เปิดให้ใช้สืบค้น::l::Grant";
$c[9][field]="granted";
$c[9][fieldtype]="list:yes,no";
$c[9][descr]="";
$c[9][defval]="yes";

$c[10][text]="Date";
$c[10][field]="dt";
$c[10][fieldtype]="date";
$c[10][descr]="";
$c[10][defval]=time();;

$c[14][text]="Date";
$c[14][field]="bibid";
$c[14][fieldtype]="addcontrol";
$c[14][descr]="";
$c[14][defval]=$ID;

//dsp


$dsp[4][text]="-";
$dsp[4][field]="id";
$dsp[4][width]="2%";
$dsp[4][filter]="module:local_checkbox";

$dsp[2][text]="Name::l::Name";
$dsp[2][field]="memid";
$dsp[2][width]="30%";
$dsp[2][filter]="module:local_detail";

$dsp[3][text]="อนุญาต::l::Granted";
$dsp[3][field]="granted";
$dsp[3][width]="2%";
$dsp[3][filter]="module:localgrant";


function localgrant($wh) {
	return "<iframe width=150 height=75 src='dublin.commentlog.php?mode=chk&chkid=$wh[id]'></iframe>";
}

function local_checkbox($wh) {
	$s="<INPUT TYPE=checkbox NAME='selectlist[]' value='$wh[id]' ID='item$wh[id]'
	style='border-width:0'>";

	return $s;
}

function local_detail($wh) {
	global $ID;
	global $startrow;
	$s="<label for='item$wh[id]'>$wh[body] <BR><FONT class=smaller>
	".getlang("โดย::l::By").": ".get_member_name($wh[memid])." ";
	$s.=getlang("เมื่อ::l::Date").":".ymd_datestr($wh[dt])." (".ymd_ago($wh[dt]).")<BR>
	".getlang("แจ้งลบ::l::Report delete").":<FONT color=darkred class=smaller> $wh[reportdelete]</FONT> ";
	if ($wh[reportdelete]>0) {
		$s.=" <A HREF='dublin.commentlog.php?ID=$ID&startrow=$startrow&clearreportdelete=$wh[id]' class='a_btn smaller' style='color:darkred'>".getlang("เคลียร์::l::Clear")."</A>";
	}
	$s.="</FONT>
	</label>";

	return $s;
}
?><TABLE width="<?php  echo $_TBWIDTH;?>" align=center>
<FORM METHOD=POST ACTION="<?php  echo $PHP_SELF;?>">
	<TR>
	<TD><?php 
fixform_tablelister($tbname," bibid='$ID' ",$dsp,"no","no","yes","ID=$ID",$c);
?></TD>
</TR>
<TR>
	<TD>
	<?php 
		echo getlang("ลบรายการที่เลือก::l::Delete selected") .": ";

	?><INPUT TYPE="submit" name="submitaction" value="Delete Selected" onclick="return confirm('<?php  echo getlang("ลบรายการที่เลือก?::l::Delete selected?");?>');"><?php 
	
	?></TD>
</TR>
<INPUT TYPE="hidden" NAME="issave" value="yes">
<INPUT TYPE="hidden" NAME="ID" value="<?php  echo $ID;?>">
</FORM>
</TABLE><?php 

index_reindex($ID);
foot();
?>