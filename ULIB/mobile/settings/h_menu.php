<?php 
;
        include ("../../inc/config.inc.php");
head();
$_REQPERM="webmobile_menu";
mn_lib();

$localcatehead="yes";

pagesection("เมนูเว็บไซต์::l::Website Menu");
$tbname="webmobile_menu";


$c[2][text]="ข้อความ::l::Text";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";
/*
$c[7][text]="ข้อความอธิบาย::l::Description";
$c[7][field]="descr";
$c[7][fieldtype]="text";
$c[7][descr]="แสดงเมื่อเอาเมาส์วาง::l::Display on mouse over";
$c[7][defval]="";*/

$c[3][text]="เรียงลำดับ::l::Order";
$c[3][field]="ordr";
$c[3][fieldtype]="number";
$c[3][descr]="";
$c[3][defval]="";



$c[9][text]="ประเภท::l::Type";
$c[9][field]="type";
$c[9][fieldtype]="foreign:-localdb-,webmobile_menu_type,code,name";
$c[9][descr]="";
$c[9][defval]="";

$c[10][text]="แสดงเมนูนี้หรือไม่::l::Show this menu";
$c[10][field]="isshow";
$c[10][fieldtype]="list:yes,no";
$c[10][descr]="";
$c[10][defval]="yes";
/*
$c[11][text]="บทความในหัวข้อ เรียงตามอะไร::l::Order articles by";
$c[11][field]="orderby";
$c[11][fieldtype]="list:lastactive,topicname";
$c[11][descr]="";
$c[11][defval]="yes";*/
/*
$c[8][text]="Icon";
$c[8][field]="icon";
$c[8][fieldtype]="list:Add.png,Applications.png,Backward.png,BallB.png,BallG.png,BallR.png,BallY.png,Book.png,Burn.png,Cancel.png,CD.png,Chart.png,ChatBubble2.png,ChatBubble.png,Chats.png,Checkmark.png,Connect.png,Copy.png,Cut.png,Delete.png,Desktop2.png,Desktop.png,Document.png,Documents.png,Down.png,DropBox.png,Edit2.png,Edit.png,Experiments.png,FavoritesAdd.png,Favorites.png,FavoritesRemove.png,Folde2.png,Folder_Apps.png,Folder_Burnable.png,Folder_Classic2.png,Folder_Classic.png,Folder_Developer.png,Folder_Documents.png,Folder_Gear.png,Folder_Generic.png,Folder_iPod.png,Folder_Library.png,Folder_Movie.png,Folder_Music.png,Folder_Pictures.png,Folder.png,Folder_Private.png,Folder_Public.png,Folder_Site.png,Folder_System2.png,Folder_System.png,Folder_User.png,Forward.png,Frolder_Drop.png,Globe2.png,Globe.png,Harddisk.png,Help2.png,Help.png,History.png,Home.png,Image.png,Information.png,Left.png,Library.png,LightBulbOff.png,LightBulbOn.png,Mail2.png,Mail.png,Movies.png,Music.png,Network.png,OK.png,Paint.png,Paste.png,Pause.png,Pencil.png,Phone.png,Pictures.png,Play.png,Print.png,Private.png,Protection.png,Recycle.png,Refresh.png,Remove.png,Right.png,Ruler.png,SaveAs.png,Save.png,Seal.png,Search.png,Sites.png,Smiley.png,Star.png,Stop2.png,Stop.png,Tool.png,Trash2.png,Trash.png,Up.png,Use2.png,User.png,Users.png,View.png,Wallpapers.png,Warning.png,ZoomIn.png,ZoomOut.png";
$c[8][descr]="";
$c[8][defval]="Folder_Generic.png";
$c[8][addon]="list-previewimg:$dcrURL"."/neoimg/webpagemenu,64,";
*/
//dsp
function localicon($wh) {
	global $dcrURL;
	return "<img src='$dcrURL/neoimg/webpagemenu/$wh[icon]' width=48 height=48>";
}
/*
$dsp[1][text]="ไอคอน::l::Icon";
$dsp[1][filter]="module:localicon";
$dsp[1][field]="icon";
$dsp[1][width]="5%";
*/
$dsp[5][text]="order::l::order";
$dsp[5][field]="ordr";
$dsp[5][width]="5%";

$dsp[2][text]="ข้อความ::l::Text";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[4][text]="จัดการ::l::Manage";
$dsp[4][field]="id";
$dsp[4][align]="center";
$dsp[4][filter]="module:localmanage";
$dsp[4][width]="20%";

$dsp[3][text]="ประเภท::l::Type";
$dsp[3][field]="type";
$dsp[3][filter]="foreign:-localdb-,webmobile_menu_type,code,name";
$dsp[3][width]="30%";

function localmanage($wh) {
	if ($wh[type]=="webboard") {
		return "<CENTER><A HREF='h_menu_descr.php?id=$wh[id]'><B>".getlang("แก้ไขตัวเลือก::l::Manage options")."</B></A></CENTER>";
	}
	if ($wh[type]=="sepper") {
		$sepperbgcol=barcodeval_get("WEBMOBILE-MENU-SEPPERCOLOR-$wh[id]");
		if ($sepperbgcol=="") {
			$sepperbgcol="a";
		}

		return "<CENTER><A HREF='h_menu_sepper.php?id=$wh[id]'><B>".getlang("เลือกTheme::l::Set Theme")."</B></A> : $sepperbgcol</CENTER>";
	}
	if ($wh[type]=="wiki") {
		$inf=tmq("select * from webmobile_menu_wiki  where refid='$wh[id]' ");
		if (tmq_num_rows($inf)==0) {
			$addstr=getlang("ยังไม่ได้กำหนดหัวข้อ::l::Not spec. Wiki");;
		} else {
			$addstr=tmq_fetch_array($inf);
			$addstr=mb_substr($addstr[text],0,20).'..,';
		}
		return "<CENTER><FONT  COLOR=666666 class=smaller2>[$addstr]<BR></FONT><A HREF='h_menu_wiki.php?id=$wh[id]'><B>".getlang("แก้หัวเรื่อง Wiki::l::Edit Wiki Topic")."</B></A></CENTER>";
	}
	if ($wh[type]=="picalbum") {
		return "<CENTER><A HREF='h_menu_descr.php?id=$wh[id]'><B>".getlang("แก้ไขตัวเลือก::l::Manage options")."</B></A></CENTER>";
	}
	//printr($wh);
	if ($wh[type]=="content") {
		return "<CENTER><A HREF='h_menu_content.php?id=$wh[id]'><B>".getlang("จัดการเนื้อหา::l::Manage")."</B></A></CENTER>";
	}
	if ($wh[type]=="url") {
		$inf=tmq("select * from webmobile_menu_url  where refid='$wh[id]' ");
		if (tmq_num_rows($inf)==0) {
			$addstr=getlang("ยังไม่ได้กำหนด URL::l::Not spec. url");;
		} else {
			$addstr=tmq_fetch_array($inf);
			$addstr=mb_substr($addstr[url],0,20).'..,'.$addstr[target].'';
		}
		return "<CENTER><FONT  COLOR=666666 class=smaller2>[$addstr]<BR></FONT><A HREF='h_menu_url.php?id=$wh[id]'><B>".getlang("แก้ไขการเชื่อมโยง::l::Edit Url")."</B></A></CENTER>";
	}
	return "&nbsp;";
}

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c," ordr ");

foot();

?>