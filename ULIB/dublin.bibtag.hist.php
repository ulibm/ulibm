<?php  
include("./inc/config.inc.php");
head();
$_REQPERM="webmenu_bibtag-list";
mn_lib();
$tbname="webpage_bibtag";

$addwordtag=urldecode($addwordtag);
$addwordtag=addslashes($addwordtag);
$addwordtag=stripslashes($addwordtag);
$addwordtag=stripslashes($addwordtag);
$addwordtag=stripslashes($addwordtag);
$addwordtag=addslashes($addwordtag);
$addwordtag=trim($addwordtag);
	$freewordtag=getval("MARC","freewordtag");

if ($addwordtag!="") {
	$oldword=tmq("select * from media where ID='$ID' ");
	$oldword=tmq_fetch_array($oldword);
	$oldword=$oldword[$freewordtag];
	$oldword=explodenewline($oldword);
	//echo "[$newword]";
	$has="no";
	@reset($oldword);
	while (list($k,$v)=each($oldword)) {
		if (trim($oldword[$k])=="^a$addwordtag") {
			$has="yes";
		}
	}
	if ($has!="yes") {
		$oldword[]="  ^a$addwordtag";
		$newword=implode($newline,$oldword);
		tmq("update media set $freewordtag='$newword' where ID='$ID' ");
	}
}
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
			tmq("delete from webpage_bibtag where id='$v' ",false);
		}
	}
  	if ($submitaction=="Allow") {
		while (list($k,$v)=each($selectlist)) {
			tmq("update webpage_bibtag set  granted='yes' where id='$v' ",false);
		}
	}
  	if ($submitaction=="Disallow") {
		while (list($k,$v)=each($selectlist)) {
			tmq("update webpage_bibtag set  granted='no' where id='$v' ",false);
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

$oldword=tmq("select * from media where ID='$ID' ");
$oldword=tmq_fetch_array($oldword);
$oldword=$oldword[$freewordtag];
$oldword=explodenewline($oldword);


$dsp[4][text]="-";
$dsp[4][field]="id";
$dsp[4][width]="2%";
$dsp[4][filter]="module:local_checkbox";

$dsp[2][text]="Name::l::Name";
$dsp[2][field]="UserAdminName";
$dsp[2][width]="40%";
$dsp[2][filter]="module:local_detail";

$dsp[5][text]="Hits";
$dsp[5][field]="id";
$dsp[5][width]="20%";
$dsp[5][filter]="module:local_hits";

$dsp[3][text]="อนุญาต::l::Granted";
$dsp[3][field]="granted";
$dsp[3][width]="2%";
$dsp[3][filter]="switchsingle";



function local_checkbox($wh) {
	$s="<INPUT TYPE=checkbox NAME='selectlist[]' value='$wh[id]' ID='item$wh[id]'
	style='border-width:0'>";

	return $s;
}

function local_detail($wh) {
	$s="<label for='item$wh[id]'>$wh[word1] <BR>
	".getlang("โดย::l::By").": ".get_member_name($wh[memid])." ";
	if ($wh[libid]!="") {
		$s.=getlang("Librarian").": ".html_library_name($wh[libid])." ";
	}
	$s.=getlang("เมื่อ::l::Date").":".ymd_datestr($wh[dt])."
	</label>";

	return $s;
}

function local_hits($wh) {
	$s="<label for='item$wh[id]'>";
	$ss=tmq("select * from statordr_search_text where head='$wh[word1]' or head like '$wh[word1] %' or head like '% $wh[word1]' or head like '% $wh[word1] %'  ");
	$ss=tmq_num_rows($ss);
	$s.=" $ss hits";
	global $oldword;
	global $freewordtag;
	global $startrow;
	global $ID;
	@reset($oldword);
	$has="no";
	while (list($k,$v)=each($oldword)) {
		if (trim($oldword[$k])=="^a$wh[word1]") {
			$has="yes";
		}
	}
	if ($has!="yes") {
		$s.="<BR><A HREF='dublin.bibtag.hist.php?ID=$ID&startrow=$startrow&addwordtag=".urlencode($wh[word1])."' class=smaller>".getlang("เพิ่มคำนี้ใน $freewordtag::l::Add this word to $freewordtag")."</A>";
	} 
	$s.="	</label>";

	return $s;
}


?><TABLE width=780 align=center>
<FORM METHOD=POST ACTION="<?php echo $PHP_SELF;?>">
	<TR>
	<TD><?php  
fixform_tablelister($tbname," bibid='$ID' ",$dsp,"yes","yes","yes","ID=$ID",$c);
?></TD>
</TR>
<TR>
	<TD>
	<?php  
		echo getlang("ลบรายการที่เลือก::l::Delete selected") .": ";

	?><INPUT TYPE="submit" name="submitaction" value="Delete Selected" onclick="return confirm('<?php echo getlang("ลบรายการที่เลือก?::l::Delete selected?");?>');"><?php  
	
	?><BR>
	<?php  
		echo getlang("อนุญาต::l::Allow") .": ";

	?><INPUT TYPE="submit" name="submitaction" value="Allow"><?php  
	
	?><BR>
	<?php  
		echo getlang("ไม่อนุญาต::l::Disallow") .": ";

	?><INPUT TYPE="submit" name="submitaction" value="Disallow" ><?php  
	
	?><BR>
	
	</TD>
</TR>
<INPUT TYPE="hidden" NAME="issave" value="yes">
<INPUT TYPE="hidden" NAME="ID" value="<?php echo $ID;?>">
</FORM>
</TABLE><?php  

index_reindex($ID);
foot();
?>