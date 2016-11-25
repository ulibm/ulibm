<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="fdbadmin";
$tmp=mn_lib();
pagesection($tmp);
$tbname="freedb_cate";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ข้อความเพิ่มเติม::l::Description";
$c[3][field]="descr";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Icon::l::Icon";
$c[4][field]="icon";
$c[4][fieldtype]="list:Activity Monitor,AddressBook,Application,Application SB,Blue Applications,Blue Backup,Blue Blog,Blue Books,Blue Box,Blue Box WIP,Blue Burn,Blue CD,Blue Classic,Blue Coffee 2,Blue Coffee alt,Blue Coffee,Blue Conversion,Blue Desktop,Blue Developer alt,Blue Developer,Blue Documents,Blue Download alt,Blue Downloads,Blue Drop,Blue Experiment,Blue External Drive Backup,Blue External Drive FireWire,Blue External Drive,Blue External Drive USB,Blue Favorites,Blue Font,Blue Generic,Blue Guikit,Blue Kraken,Blue Library,Blue Login,Blue MacThemes,Blue Magic Bunny,Blue Marker,Blue Movies alt,Blue Movies old,Blue Movies,Blue Music,Blue New,Blue Package,Blue Paint,Blue Photo film,Blue Photos,Blue Pictures,Blue Pirates,Blue Pocket ( iPod shuffle),Blue Pocket,Blue Private,Blue Prohibition,Blue Public,Blue Recycling,Blue RSS,Blue Ruler,Blue Security,Blue Sites,Blue Sketch,Blue Sticker MILO,Blue Sticker,Blue Stock,Blue System,Blue Themes,Blue Themes WIP,Blue Users,Blue Wall,Blue WANTED,Blue Waterfall,Blue Water leak,Blue Web alt,Blue Web,Blue Zip,Burning,CD,CD-R,CD-RW,Cinema Display,Clipping Picture,Clipping Sound,Clipping Text alt,Clipping Text,Clipping Unknown,Coffee,Computer,Connect,Dashboard,Delete,Desktop,Disconnected,Documents,dot Mac Logo Graphite,dot Mac Logo,DVD,DVD RAM,DVD-R,DVD+R,DVD-RW,DVD+RW,File Server Graphite,File Server,Finder,Font,Generic Document,Get info,Home alt,Home,Internal Drive alt1,Internal Drive alt2,Internal Drive,Internal Drive Standard,iTunes,Lightbrown Applications,Lightbrown Backup,Lightbrown Blog,Lightbrown Books,Lightbrown Box,Lightbrown Box WIP,Lightbrown Burn,Lightbrown CD,Lightbrown Classic,Lightbrown Coffee 2,Lightbrown Coffee alt,Lightbrown Coffee,Lightbrown Conversion,Lightbrown Desktop,Lightbrown Developer alt,Lightbrown Developer,Lightbrown Documents,Lightbrown Download alt,Lightbrown Downloads,Lightbrown Drop,Lightbrown Experiment,Lightbrown External Drive Backup,Lightbrown External Drive FireWire,Lightbrown External Drive,Lightbrown External Drive USB,Lightbrown Favorites,Lightbrown Font,Lightbrown Generic,Lightbrown Guikit,Lightbrown Kraken,Lightbrown Library,Lightbrown Login,Lightbrown MacThemes,Lightbrown Magic Bunny,Web Site";
$c[4][descr]="";
$c[4][defval]="";
$c[4][addon]="list-previewimg:$dcrURL"."neoimg/freedbicon,64,.png";

//dsp

$dsp[4][text]="Icon::l::Icon";
$dsp[4][field]="icon";
$dsp[4][filter]="module:localicon";
$dsp[4][width]="10%";

$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="ข้อความเพิ่มเติม::l::Description";
$dsp[3][field]="descr";
$dsp[3][width]="30%";

$dsp[5][text]="จัดการ::l::Manage";
$dsp[5][field]="name";
$dsp[5][align]="center";
$dsp[5][filter]="linkout:./sub.php?main=[value-id]";
$dsp[5][width]="15%";

function localicon($wh) {
				 global $dcrURL;
				 return "<img src='$dcrURL/neoimg/freedbicon/$wh[icon].png' width=48>";
}

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);
?><center><a class='smaller a_btn' href='../freedb.php' target=_blank><?php echo getlang("ไปยังฐานข้อมูลออนไลน์ส่วนผู้ใช้::l::Go to member's view");?></a></center><?php
foot();
?>