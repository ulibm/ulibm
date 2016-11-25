<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="createlist";
mn_lib();

$tbname="createlist_main";

if ($dup1!="") {
	?><TABLE width=700 align=center class=table_border>
<FORM METHOD=POST ACTION="index.php">
<INPUT TYPE="hidden" NAME="dup2" value="<?php  echo $dup1?>">
			<TR>
		<TD class=table_head><?php  echo getlang("กรุณาใส่ชื่อใหม่::l::Please set new name"); ?></TD>
		<TD class=table_td><INPUT TYPE="text" NAME="newname" value="<?php 
	$s=tmq("select * from createlist_main where id='$dup1' ");	
	$s=tmq_fetch_array($s);
	echo $s[name];
	?>"> 
	<INPUT TYPE="submit" value="<?php  echo getlang("ทำซ้ำ::l::Duplicate"); ?>"  class=a_btn> 
	<A HREF="index.php" class=a_btn style="color: darkred;"><?php  echo getlang("ยกเลิก::l::Cancel");?></A></TD>
	</TR>
	</FORM>
	</TABLE><?php 
}

$newname=trim($newname);
if ($dup2!="" && $newname!="") {
	$newname=addslashes($newname);
	$now=time();
	tmq("insert into createlist_main set name='$newname' , dt='$now' ,loginid='$useradminid'  ");
	$newid=tmq_insert_id();
	$s=tmq("select * from createlist_rule where pid='$dup2' ");
	while ($r=tmq_fetch_array($s)) {
		tmq("insert into createlist_rule set pid='$newid',
		bool='$r[bool]',
		tagid='$r[tagid]',
		decis='$r[decis]',
		val='$r[val]',
		ordr='$r[ordr]'
		");
	}
	$s=tmq("select * from createlist_itemrule where pid='$dup2' ",false);
	while ($r=tmq_fetch_array($s)) {
		tmq("insert into createlist_itemrule set pid='$newid',
		val='$r[val]',
		idlist='$r[idlist]',
		decis='$r[decis]'
		");
	}
}

$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="เวลาที่สร้าง::l::Date";
$c[3][field]="dt";
$c[3][fieldtype]="autotime";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ผู้สร้าง::l::Officer";
$c[4][field]="loginid";
$c[4][fieldtype]="autoofficer";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="สร้างรายการทรัพยากร::l::Create Materials list";
$c[5][field]="ftlist";
$c[5][fieldtype]="yesno";
$c[5][descr]="";
$c[5][defval]="NO";

/*
$c[4][text]="Icon::l::Icon";
$c[4][field]="icon";
$c[4][fieldtype]="list:Activity Monitor,AddressBook,Application,Application SB,Blue Applications,Blue Backup,Blue Blog,Blue Books,Blue Box,Blue Box WIP,Blue Burn,Blue CD,Blue Classic,Blue Coffee 2,Blue Coffee alt,Blue Coffee,Blue Conversion,Blue Desktop,Blue Developer alt,Blue Developer,Blue Documents,Blue Download alt,Blue Downloads,Blue Drop,Blue Experiment,Blue External Drive Backup,Blue External Drive FireWire,Blue External Drive,Blue External Drive USB,Blue Favorites,Blue Font,Blue Generic,Blue Guikit,Blue Kraken,Blue Library,Blue Login,Blue MacThemes,Blue Magic Bunny,Blue Marker,Blue Movies alt,Blue Movies old,Blue Movies,Blue Music,Blue New,Blue Package,Blue Paint,Blue Photo film,Blue Photos,Blue Pictures,Blue Pirates,Blue Pocket ( iPod shuffle),Blue Pocket,Blue Private,Blue Prohibition,Blue Public,Blue Recycling,Blue RSS,Blue Ruler,Blue Security,Blue Sites,Blue Sketch,Blue Sticker MILO,Blue Sticker,Blue Stock,Blue System,Blue Themes,Blue Themes WIP,Blue Users,Blue Wall,Blue WANTED,Blue Waterfall,Blue Water leak,Blue Web alt,Blue Web,Blue Zip,Burning,CD,CD-R,CD-RW,Cinema Display,Clipping Picture,Clipping Sound,Clipping Text alt,Clipping Text,Clipping Unknown,Coffee,Computer,Connect,Dashboard,Delete,Desktop,Disconnected,Documents,dot Mac Logo Graphite,dot Mac Logo,DVD,DVD RAM,DVD-R,DVD+R,DVD-RW,DVD+RW,File Server Graphite,File Server,Finder,Font,Generic Document,Get info,Home alt,Home,Internal Drive alt1,Internal Drive alt2,Internal Drive,Internal Drive Standard,iTunes,Lightbrown Applications,Lightbrown Backup,Lightbrown Blog,Lightbrown Books,Lightbrown Box,Lightbrown Box WIP,Lightbrown Burn,Lightbrown CD,Lightbrown Classic,Lightbrown Coffee 2,Lightbrown Coffee alt,Lightbrown Coffee,Lightbrown Conversion,Lightbrown Desktop,Lightbrown Developer alt,Lightbrown Developer,Lightbrown Documents,Lightbrown Download alt,Lightbrown Downloads,Lightbrown Drop,Lightbrown Experiment,Lightbrown External Drive Backup,Lightbrown External Drive FireWire,Lightbrown External Drive,Lightbrown External Drive USB,Lightbrown Favorites,Lightbrown Font,Lightbrown Generic,Lightbrown Guikit,Lightbrown Kraken,Lightbrown Library,Lightbrown Login,Lightbrown MacThemes,Lightbrown Magic Bunny,Web Site";
$c[4][descr]="";
$c[4][defval]="";
$c[4][addon]="list-previewimg:$dcrURL"."neoimg/freedbicon,64,.png";
*/
//dsp
/*
$dsp[4][text]="Icon::l::Icon";
$dsp[4][field]="icon";
$dsp[4][filter]="module:localicon";
$dsp[4][width]="10%";
*/
$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][filter]="module:localname";
$dsp[2][width]="20%";
function localname($wh) {
	global $dcrURL;
	$s=$wh[name];
	if (strtolower($wh[ftlist])=="yes") {
		$s.="<br><a href='$dcrURL"."search-browse-ftlist.php?id=$wh[id]' class=smaller2 target=_blank>".getlang("สร้างรายการทรัพยากร::l::Create Materials list")."</a>";
	}
	return $s;
}

if (library_gotpermission("createlist-man")) {
   $dsp[5][text]="จัดการกฏ::l::Manage select rule";
   $dsp[5][field]="name";
   $dsp[5][align]="center";
   $dsp[5][filter]="module:local_manrule";
   $dsp[5][width]="15%";
}

$dsp[6][text]="ส่งออกผลลัพธ์::l::Export Result";
$dsp[6][field]="name";
$dsp[6][align]="center";
$dsp[6][filter]="module:local_export";
$dsp[6][width]="16%";

if (library_gotpermission("createlist-man")) {
   $dsp[7][text]="ทำสำเนารายการนี้::l::Duplicate this record";
   $dsp[7][field]="name";
   $dsp[7][align]="center";
   $dsp[7][filter]="module:local_duplicate";
   $dsp[7][width]="17%";
}
function localicon($wh) {
				 global $dcrURL;
				 return "<img src='$dcrURL/neoimg/freedbicon/$wh[icon].png' width=48>";
}
function local_manrule($wh) {
				 global $dcrURL;
				 $c=tmq("select * from createlist_rule where pid='$wh[id]' ");
				 $c="(".tmq_num_rows($c).")";
				 $c2=tmq("select * from createlist_itemrule where pid='$wh[id]' and idlist<>'' ");
				 if (tnr($c2)>0) {
					$c2str="<br><font class=smaller2>".getlang("มีกฏไอเทม::l::Have item rule")."</font>";
				 };
				 return "<A HREF='sub_rule.php?main=$wh[id]'>".getlang("จัดการกฏ::l::Manage")."</A> <FONT class=smaller2>$c</FONT>$c2str";
}
function local_duplicate($wh) {
				 global $dcrURL;
				 return "<A HREF='index.php?dup1=$wh[id]'>".getlang("ทำสำเนา::l::Duplicate")."</A> <FONT class=smaller2>$c</FONT>";
}
function local_export($wh) {
				 global $dcrURL;
				 $c=tmq("select * from createlist_rule where pid='$wh[id]' ");
				 $c=tmq_num_rows($c);
				 $c2=tmq("select * from createlist_itemrule where pid='$wh[id]' and idlist<>'' ");

				 if ($c!=0 || tnr($c2)>0) {
					 if ($wh[cache_dt]) {
						$addstr="<FONT class=smaller2><BR>ผลการคำนวณครั้งที่แล้ว<BR>เมื่อ ". ymd_ago($wh[cache_dt]).
							"<BR> Bib=".number_format($wh[cache_bib]).
							" Item=".number_format($wh[cache_item])."</FONT>";
					 }
					 return "<A HREF='sub_export.php?main=$wh[id]&createexport=yes'>".getlang("ส่งออก::l::Export")."</A>$addstr";
				 } else {
					return "-";
				 }
}

$perm="yes";
if (!library_gotpermission("createlist-man")) {
   $perm="no";
}
fixform_tablelister($tbname," 1 ",$dsp,"$perm","$perm","$perm","mi=$mi",$c);

foot();
?>